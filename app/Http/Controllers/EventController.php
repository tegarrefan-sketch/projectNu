<?php

namespace App\Http\Controllers;

use App\Models\Banom;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Active & Upcoming Events (Tanggal >= Hari Ini)
     */
    public function index(Request $request)
    {
        $banoms = Banom::orderBy('urutan')->get();
        $banomSlug = $request->query('banom');
        $search = $request->query('q');

        $query = Event::with('banom')
            ->where('status', '!=', 'Dibatalkan')
            ->where('tanggal', '>=', now()->toDateString());

        if ($banomSlug) {
            $banom = Banom::where('slug', $banomSlug)->first();
            if ($banom) {
                $query->where('banom_id', $banom->id);
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('lokasi', 'LIKE', "%{$search}%");
            });
        }

        // Upcoming events ordered by closest date
        $events = $query
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->paginate(6)
            ->withQueryString();

        $pastCount = Event::where('status', '!=', 'Dibatalkan')
            ->where('tanggal', '<', now()->toDateString())
            ->count();

        return view('event.index', compact('events', 'banoms', 'banomSlug', 'search', 'pastCount'));
    }

    /**
     * Archive of Past Events (Tanggal < Hari Ini)
     */
    public function archive(Request $request)
    {
        $banoms = Banom::orderBy('urutan')->get();
        $banomSlug = $request->query('banom');
        $search = $request->query('q');
        $bulan = $request->query('bulan');
        $tahun = $request->query('tahun');

        $query = Event::with('banom')
            ->where('status', '!=', 'Dibatalkan')
            ->where('tanggal', '<', now()->toDateString());

        if ($banomSlug) {
            $banom = Banom::where('slug', $banomSlug)->first();
            if ($banom) {
                $query->where('banom_id', $banom->id);
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('lokasi', 'LIKE', "%{$search}%");
            });
        }

        if ($bulan) {
            $query->whereMonth('tanggal', $bulan);
        }

        if ($tahun) {
            $query->whereYear('tanggal', $tahun);
        }

        // Available years for filter dropdown
        $availableYears = Event::where('status', '!=', 'Dibatalkan')
            ->where('tanggal', '<', now()->toDateString())
            ->selectRaw('YEAR(tanggal) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year')
            ->toArray();

        if (empty($availableYears)) {
            $availableYears = [date('Y')];
        }

        $events = $query
            ->orderByDesc('tanggal')
            ->orderByDesc('waktu_mulai')
            ->paginate(8)
            ->withQueryString();

        return view('event.archive', compact('events', 'banoms', 'banomSlug', 'search', 'bulan', 'tahun', 'availableYears'));
    }

    public function show(string $slug)
    {
        $event = Event::with('banom')->where('slug', $slug)->firstOrFail();

        $otherEvents = Event::where('id', '!=', $event->id)
            ->upcoming()
            ->take(3)
            ->get();

        return view('event.show', compact('event', 'otherEvents'));
    }
}
