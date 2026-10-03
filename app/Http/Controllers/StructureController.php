<?php

namespace App\Http\Controllers;

use App\Models\Banom;
use App\Models\OrganizationStructure;
use App\Models\Profile;
use Illuminate\Http\Request;

class StructureController extends Controller
{
    public function index(Request $request)
    {
        $profile = Profile::current();
        $banoms = Banom::orderBy('urutan')->get();

        $tab = $request->query('tab', 'all');
        $search = $request->query('q');

        $query = OrganizationStructure::with('banom')
            ->where('status', 'Aktif')
            ->orderBy('urutan');

        if ($tab !== 'all') {
            if ($tab === 'syuriyah') {
                $query->whereIn('kategori_hierarki', ['mustasyar', 'syuriyah']);
            } elseif ($tab === 'tanfidziyah') {
                $query->where('kategori_hierarki', 'tanfidziyah');
            } elseif ($tab === 'banom') {
                $query->where('kategori_hierarki', 'banom');
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('jabatan', 'LIKE', "%{$search}%");
            });
        }

        $structures = $query->get();

        return view('structure.index', compact('profile', 'banoms', 'structures', 'tab', 'search'));
    }
}
