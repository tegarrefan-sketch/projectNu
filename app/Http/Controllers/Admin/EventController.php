<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banom;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $banoms = Banom::orderBy('urutan')->get();
        $banomId = $request->query('banom_id');
        $search = $request->query('q');

        $query = Event::with('banom')->orderBy('tanggal');

        if ($banomId !== null && $banomId !== '') {
            if ($banomId === 'prnu') {
                $query->whereNull('banom_id');
            } else {
                $query->where('banom_id', $banomId);
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('lokasi', 'LIKE', "%{$search}%");
            });
        }

        $events = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Event::count(),
            'upcoming' => Event::where('tanggal', '>=', now()->toDateString())->count(),
            'past' => Event::where('tanggal', '<', now()->toDateString())->count(),
        ];

        return view('admin.event.index', compact('events', 'banoms', 'banomId', 'search', 'stats'));
    }

    public function create()
    {
        $banoms = Banom::where('status', 'Aktif')->orderBy('urutan')->get();
        return view('admin.event.create', compact('banoms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'banom_id' => 'nullable|exists:banoms,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'nullable',
            'waktu_selesai' => 'nullable',
            'lokasi' => 'required|string|max:255',
            'status' => 'required|in:Akan Datang,Selesai,Dibatalkan',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ], [
            'title.required' => 'Nama/Judul agenda wajib diisi.',
            'tanggal.required' => 'Tanggal agenda wajib diisi.',
            'lokasi.required' => 'Lokasi kegiatan wajib diisi.',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('events', 'public');
        }

        Event::create($validated);

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda kegiatan berhasil ditambahkan.');
    }

    public function edit(Event $agendum)
    {
        $banoms = Banom::where('status', 'Aktif')->orderBy('urutan')->get();
        return view('admin.event.edit', ['event' => $agendum, 'banoms' => $banoms]);
    }

    public function update(Request $request, Event $agendum)
    {
        $validated = $request->validate([
            'banom_id' => 'nullable|exists:banoms,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'nullable',
            'waktu_selesai' => 'nullable',
            'lokasi' => 'required|string|max:255',
            'status' => 'required|in:Akan Datang,Selesai,Dibatalkan',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($agendum->thumbnail && Storage::disk('public')->exists($agendum->thumbnail)) {
                Storage::disk('public')->delete($agendum->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('events', 'public');
        }

        $agendum->update($validated);

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda kegiatan berhasil diperbarui.');
    }

    public function destroy(Event $agendum)
    {
        $agendum->delete();
        return redirect()->route('admin.agenda.index')->with('success', 'Agenda kegiatan berhasil dihapus.');
    }
}
