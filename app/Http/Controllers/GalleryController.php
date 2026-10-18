<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryPhoto;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');
        $search = $request->query('q');

        $query = Gallery::with(['photos'])
            ->where('status', 'Publik');

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$search}%")
                  ->orWhere('lokasi', 'LIKE', "%{$search}%");
            });
        }

        $galleries = $query->orderByDesc('tanggal')->paginate(9)->withQueryString();

        $categories = Gallery::where('status', 'Publik')
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->values();

        // Also get all flat photos for an instant photostream preview if desired
        $recentPhotos = GalleryPhoto::with('gallery')
            ->whereHas('gallery', function ($q) {
                $q->where('status', 'Publik');
            })
            ->latest('created_at')
            ->take(12)
            ->get();

        return view('gallery.index', compact('galleries', 'categories', 'kategori', 'search', 'recentPhotos'));
    }

    public function show(string $slug)
    {
        $gallery = Gallery::with(['photos'])
            ->where('slug', $slug)
            ->where('status', 'Publik')
            ->firstOrFail();

        $otherGalleries = Gallery::where('status', 'Publik')
            ->where('id', '!=', $gallery->id)
            ->orderByDesc('tanggal')
            ->take(3)
            ->get();

        return view('gallery.show', compact('gallery', 'otherGalleries'));
    }
}
