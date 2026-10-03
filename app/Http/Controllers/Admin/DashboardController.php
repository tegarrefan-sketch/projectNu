<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use App\Models\Banom;
use App\Models\Event;
use App\Models\Kta;
use App\Models\Member;
use App\Models\OrganizationStructure;
use App\Models\Post;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $banoms = Banom::withCount(['members', 'organizationStructures', 'posts', 'events'])
            ->orderBy('urutan')
            ->get();

        $totalBanom = $banoms->count();
        $totalPengurus = OrganizationStructure::where('status', 'Aktif')->count();
        $totalAnggota = Member::count();
        $totalKta = Kta::count();
        $ktaAktif = Kta::where('status', 'Aktif')->count();
        $totalBerita = Post::count();
        $totalAgenda = Event::count();
        $totalAspirasi = Aspiration::count();
        $aspirasiBaru = Aspiration::where('status', 'Baru')->count();

        // KTA stats per BANOM
        $ktaPerBanom = [];
        foreach ($banoms as $banom) {
            $ktaPerBanom[$banom->singkatan] = Kta::whereHas('member', function ($q) use ($banom) {
                $q->where('banom_id', $banom->id);
            })->count();
        }

        // Recent items
        $recentMembers = Member::with('banom', 'kta')->latest()->take(5)->get();
        $recentPosts = Post::with('banom')->latest()->take(5)->get();
        $recentAspirations = Aspiration::latest()->take(5)->get();
        $upcomingEvents = Event::upcoming()->take(3)->get();

        return view('admin.dashboard', compact(
            'banoms',
            'totalBanom',
            'totalPengurus',
            'totalAnggota',
            'totalKta',
            'ktaAktif',
            'totalBerita',
            'totalAgenda',
            'totalAspirasi',
            'aspirasiBaru',
            'ktaPerBanom',
            'recentMembers',
            'recentPosts',
            'recentAspirations',
            'upcomingEvents'
        ));
    }
}
