<?php

namespace App\Http\Controllers;

use App\Models\Banom;
use Illuminate\Http\Request;

class BanomController extends Controller
{
    public function index()
    {
        $banoms = Banom::withCount(['members', 'organizationStructures', 'posts', 'events'])
            ->orderBy('urutan')
            ->get();

        return view('banom.index', compact('banoms'));
    }

    public function show(string $slug)
    {
        $banom = Banom::where('slug', $slug)
            ->withCount(['members' => function ($q) {
                $q->where('status', 'Aktif');
            }])
            ->firstOrFail();

        $structures = $banom->organizationStructures()
            ->where('status', 'Aktif')
            ->orderBy('urutan')
            ->get();

        $members = $banom->members()
            ->where('status', 'Aktif')
            ->latest()
            ->take(8)
            ->get();

        $posts = $banom->posts()
            ->published()
            ->latest('published_at')
            ->take(6)
            ->get();

        $events = $banom->events()
            ->upcoming()
            ->take(4)
            ->get();

        return view('banom.show', compact('banom', 'structures', 'members', 'posts', 'events'));
    }
}
