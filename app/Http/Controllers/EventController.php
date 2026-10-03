<?php

namespace App\Http\Controllers;

use App\Models\Banom;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $banoms = Banom::orderBy('urutan')->get();
        $banomSlug = $request->query('banom');
        $search = $request->query('q');

        $query = Event::with('banom')->where('status', '!=', 'Dibatalkan');

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

        $upcomingEvents = (clone $query)
            ->where('tanggal', '>=', now()->toDateString())
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->paginate(6, ['*'], 'upcoming_page')
            ->withQueryString();

        $pastEvents = (clone $query)
            ->where('tanggal', '<', now()->toDateString())
            ->orderByDesc('tanggal')
            ->take(4)
            ->get();

        return view('event.index', compact('upcomingEvents', 'pastEvents', 'banoms', 'banomSlug', 'search'));
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
