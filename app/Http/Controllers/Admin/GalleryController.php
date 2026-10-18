<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');
        $query = Gallery::withCount('photos');

        if ($search) {
            $query->where('judul', 'LIKE', "%{$search}%")
                  ->orWhere('lokasi', 'LIKE', "%{$search}%");
        }

        $galleries = $query->orderByDesc('tanggal')->paginate(10)->withQueryString();

        return view('admin.gallery.index', compact('galleries', 'search'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi' => 'nullable|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:Publik,Draf',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'judul.required' => 'Judul album kegiatan wajib diisi.',
            'tanggal.required' => 'Tanggal kegiatan wajib diisi.',
            'cover.image' => 'Cover harus berupa file gambar valid.',
            'photos.*.image' => 'Setiap foto harus berupa file gambar valid (JPG, PNG, WEBP).',
            'photos.*.max' => 'Ukuran maksimal foto per file adalah 5MB.',
        ]);

        $slug = Str::slug($validated['judul']);
        $originalSlug = $slug;
        $counter = 1;
        while (Gallery::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $coverPath = null;
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('gallery', 'public');
        }

        $gallery = Gallery::create([
            'judul' => $validated['judul'],
            'slug' => $slug,
            'tanggal' => $validated['tanggal'],
            'lokasi' => $validated['lokasi'] ?? null,
            'kategori' => $validated['kategori'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status' => $validated['status'],
            'cover' => $coverPath,
        ]);

        // Upload multiple photos
        if ($request->hasFile('photos')) {
            $urutan = 1;
            foreach ($request->file('photos') as $photoFile) {
                $path = $photoFile->store('gallery', 'public');
                GalleryPhoto::create([
                    'gallery_id' => $gallery->id,
                    'foto' => $path,
                    'caption' => null,
                    'urutan' => $urutan++,
                ]);

                // If no cover was explicitly uploaded, set first photo as cover
                if (!$gallery->cover) {
                    $gallery->update(['cover' => $path]);
                }
            }
        }

        return redirect()->route('admin.galeri.index')->with('success', 'Album galeri kegiatan berhasil ditambahkan.');
    }

    public function edit(Gallery $galeri)
    {
        $galeri->load('photos');
        return view('admin.gallery.edit', ['gallery' => $galeri]);
    }

    public function update(Request $request, Gallery $galeri)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi' => 'nullable|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:Publik,Draf',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($request->hasFile('cover')) {
            if ($galeri->cover && !Str::endsWith($galeri->cover, '.svg')) {
                Storage::disk('public')->delete($galeri->cover);
            }
            $galeri->cover = $request->file('cover')->store('gallery', 'public');
        }

        $galeri->update([
            'judul' => $validated['judul'],
            'tanggal' => $validated['tanggal'],
            'lokasi' => $validated['lokasi'] ?? null,
            'kategori' => $validated['kategori'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status' => $validated['status'],
        ]);

        // Upload additional photos if any
        if ($request->hasFile('photos')) {
            $lastUrutan = $galeri->photos()->max('urutan') ?? 0;
            foreach ($request->file('photos') as $photoFile) {
                $lastUrutan++;
                $path = $photoFile->store('gallery', 'public');
                GalleryPhoto::create([
                    'gallery_id' => $galeri->id,
                    'foto' => $path,
                    'caption' => null,
                    'urutan' => $lastUrutan,
                ]);

                if (!$galeri->cover) {
                    $galeri->update(['cover' => $path]);
                }
            }
        }

        return redirect()->route('admin.galeri.index')->with('success', 'Album galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $galeri)
    {
        foreach ($galeri->photos as $photo) {
            if ($photo->foto && !Str::endsWith($photo->foto, '.svg')) {
                Storage::disk('public')->delete($photo->foto);
            }
        }

        if ($galeri->cover && !Str::endsWith($galeri->cover, '.svg')) {
            Storage::disk('public')->delete($galeri->cover);
        }

        $galeri->delete();

        return redirect()->route('admin.galeri.index')->with('success', 'Album kegiatan berhasil dihapus.');
    }

    public function destroyPhoto(GalleryPhoto $photo)
    {
        $galleryId = $photo->gallery_id;
        if ($photo->foto && !Str::endsWith($photo->foto, '.svg')) {
            Storage::disk('public')->delete($photo->foto);
        }
        $photo->delete();

        return back()->with('success', 'Foto berhasil dihapus dari album.');
    }
}
