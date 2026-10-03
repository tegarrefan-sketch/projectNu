<?php

namespace App\Http\Controllers;

use App\Models\OrganizationStructure;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Profile::current();
        
        $mustasyar = OrganizationStructure::where('kategori_hierarki', 'mustasyar')
            ->where('status', 'Aktif')
            ->orderBy('urutan')
            ->get();

        $syuriyah = OrganizationStructure::where('kategori_hierarki', 'syuriyah')
            ->where('status', 'Aktif')
            ->orderBy('urutan')
            ->get();

        $tanfidziyah = OrganizationStructure::where('kategori_hierarki', 'tanfidziyah')
            ->where('status', 'Aktif')
            ->orderBy('urutan')
            ->get();

        return view('profile', compact('profile', 'mustasyar', 'syuriyah', 'tanfidziyah'));
    }
}
