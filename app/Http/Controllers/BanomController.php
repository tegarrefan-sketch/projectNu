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

        $officers = $banom->officers()
            ->where('is_active', true)
            ->with(['position', 'member'])
            ->join('positions', 'banom_officers.position_id', '=', 'positions.id')
            ->orderBy('positions.urutan')
            ->orderBy('banom_officers.urutan')
            ->select('banom_officers.*')
            ->get();

        $groupedOfficers = $officers->groupBy(function ($officer) {
            return $officer->position->nama ?? 'Pengurus';
        });

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

        return view('banom.show', compact('banom', 'officers', 'groupedOfficers', 'structures', 'members', 'posts', 'events'));
    }
}
