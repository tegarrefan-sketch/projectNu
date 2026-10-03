<?php

namespace App\Http\Controllers;

use App\Models\Banom;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $banoms = Banom::orderBy('urutan')->get();
        $category = $request->query('kategori', 'all');
        $search = $request->query('q');
        $sort = $request->query('sort', 'terbaru');

        $query = Post::published()->with('banom');

        if ($category !== 'all') {
            if ($category === 'prnu') {
                $query->whereNull('banom_id');
            } else {
                $banom = Banom::where('slug', $category)->first();
                if ($banom) {
                    $query->where('banom_id', $banom->id);
                } else {
                    $query->where('kategori', $category);
                }
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('excerpt', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%");
            });
        }

        if ($sort === 'terpopuler') {
            $query->orderByDesc('views');
        } else {
            $query->latest('published_at');
        }

        $posts = $query->paginate(9)->withQueryString();

        $featured = null;
        if ($category === 'all' && !$search && $posts->currentPage() === 1) {
            $featured = Post::published()->latest('published_at')->first();
        }

        return view('post.index', compact('posts', 'banoms', 'category', 'search', 'sort', 'featured'));
    }

    public function show(string $slug)
    {
        $post = Post::published()->with('banom')->where('slug', $slug)->firstOrFail();
        
        // Increment views
        $post->increment('views');

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->where(function ($q) use ($post) {
                if ($post->banom_id) {
                    $q->where('banom_id', $post->banom_id);
                } else {
                    $q->where('kategori', $post->kategori);
                }
            })
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('post.show', compact('post', 'relatedPosts'));
    }
}
