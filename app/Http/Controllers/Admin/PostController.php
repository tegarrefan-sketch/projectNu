<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banom;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $banoms = Banom::orderBy('urutan')->get();
        $banomId = $request->query('banom_id');
        $status = $request->query('status');
        $search = $request->query('q');

        $query = Post::with('banom')->latest('published_at');

        if ($banomId !== null && $banomId !== '') {
            if ($banomId === 'prnu') {
                $query->whereNull('banom_id');
            } else {
                $query->where('banom_id', $banomId);
            }
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('excerpt', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%");
            });
        }

        $posts = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Post::count(),
            'published' => Post::where('status', 'published')->count(),
            'draft' => Post::where('status', 'draft')->count(),
            'views' => Post::sum('views'),
        ];

        return view('admin.post.index', compact('posts', 'banoms', 'banomId', 'status', 'search', 'stats'));
    }

    public function create()
    {
        $banoms = Banom::where('status', 'Aktif')->orderBy('urutan')->get();
        return view('admin.post.create', compact('banoms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'banom_id' => 'nullable|exists:banoms,id',
            'kategori' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'author' => 'required|string|max:100',
            'status' => 'required|in:published,draft',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ], [
            'title.required' => 'Judul berita wajib diisi.',
            'content.required' => 'Isi berita/artikel wajib diisi.',
            'author.required' => 'Penulis atau nama redaksi wajib diisi.',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        $validated['published_at'] = $validated['status'] === 'published' ? now() : null;

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('posts', 'public');
        }

        Post::create($validated);

        return redirect()->route('admin.berita.index')->with('success', 'Warta berita berhasil dibuat.');
    }

    public function edit(Post $beritum)
    {
        $banoms = Banom::where('status', 'Aktif')->orderBy('urutan')->get();
        return view('admin.post.edit', ['post' => $beritum, 'banoms' => $banoms]);
    }

    public function update(Request $request, Post $beritum)
    {
        $validated = $request->validate([
            'banom_id' => 'nullable|exists:banoms,id',
            'kategori' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'author' => 'required|string|max:100',
            'status' => 'required|in:published,draft',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($beritum->thumbnail && Storage::disk('public')->exists($beritum->thumbnail)) {
                Storage::disk('public')->delete($beritum->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('posts', 'public');
        }

        if ($validated['status'] === 'published' && !$beritum->published_at) {
            $validated['published_at'] = now();
        }

        $beritum->update($validated);

        return redirect()->route('admin.berita.index')->with('success', 'Warta berita berhasil diperbarui.');
    }

    public function togglePublish(Post $beritum)
    {
        $newStatus = $beritum->status === 'published' ? 'draft' : 'published';
        $beritum->update([
            'status' => $newStatus,
            'published_at' => $newStatus === 'published' ? ($beritum->published_at ?? now()) : $beritum->published_at,
        ]);

        return back()->with('success', "Status berita diubah menjadi " . ucfirst($newStatus));
    }

    public function destroy(Post $beritum)
    {
        $beritum->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Warta berita berhasil dihapus.');
    }
}
