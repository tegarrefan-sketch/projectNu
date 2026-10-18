<?php

namespace App\Http\Controllers;

use App\Models\Banom;
use App\Models\Donation;
use App\Models\Event;
use App\Models\GalleryPhoto;
use App\Models\Kta;
use App\Models\Member;
use App\Models\OrganizationStructure;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $profile = Profile::current();
        $banoms = Banom::where('status', 'Aktif')->orderBy('urutan')->get();
        $posts = Post::published()->with('banom')->latest('published_at')->take(4)->get();
        $events = Event::upcoming()->with('banom')->take(4)->get();
        
        $totalMembers = Member::count();
        $totalKta = Kta::where('status', 'Aktif')->count();
        $totalBanom = $banoms->count();
        $totalInfaqTerkumpul = Donation::where('status', 'Terverifikasi')->sum('nominal');

        $structures = OrganizationStructure::where('status', 'Aktif')
            ->whereIn('kategori_hierarki', ['syuriyah', 'tanfidziyah'])
            ->orderBy('urutan')
            ->take(6)
            ->get();

        // 4-6 latest gallery photos for home preview
        $latestPhotos = GalleryPhoto::with('gallery')
            ->whereHas('gallery', function ($q) {
                $q->where('status', 'Publik');
            })
            ->latest('created_at')
            ->take(6)
            ->get();

        return view('home', compact(
            'profile',
            'banoms',
            'posts',
            'events',
            'totalMembers',
            'totalKta',
            'totalBanom',
            'totalInfaqTerkumpul',
            'structures',
            'latestPhotos'
        ));
    }
}
