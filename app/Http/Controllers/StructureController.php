<?php

namespace App\Http\Controllers;

use App\Models\Banom;
use App\Models\BanomOfficer;
use App\Models\OrganizationStructure;
use App\Models\Profile;
use Illuminate\Http\Request;

class StructureController extends Controller
{
    public function index(Request $request)
    {
        $profile = Profile::current();
        $tab = $request->query('tab', 'ranting');
        $search = $request->query('q');

        // 1. BANOM TINGKAT RANTING (6 Banom resmi)
        $banoms = Banom::with([
                'divisions' => function ($q) {
                    $q->orderBy('urutan');
                },
                'officers' => function ($q) {
                    $q->where('is_active', true)
                      ->with(['position', 'member', 'division'])
                      ->join('positions', 'banom_officers.position_id', '=', 'positions.id')
                      ->orderBy('positions.urutan_hierarki')
                      ->orderBy('positions.urutan')
                      ->orderBy('banom_officers.urutan')
                      ->select('banom_officers.*');
                }
            ])
            ->withCount([
                'members',
                'officers' => function ($q) {
                    $q->where('is_active', true);
                }
            ])
            ->where('kategori', 'banom')
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get();

        // 2. PRNU (Pengurus Ranting Nahdlatul Ulama)
        $prnu = Banom::where('kategori', 'ranting')->first() 
            ?? Banom::where('singkatan', 'PRNU')->first();

        $prnuOfficers = collect();
        if ($prnu) {
            $prnuQuery = $prnu->banomOfficers()
                ->where('is_active', true)
                ->with(['position', 'member'])
                ->join('positions', 'banom_officers.position_id', '=', 'positions.id')
                ->orderBy('positions.urutan_hierarki')
                ->orderBy('positions.urutan')
                ->orderBy('banom_officers.urutan')
                ->select('banom_officers.*');

            if ($search) {
                $prnuQuery->where(function ($q) use ($search) {
                    $q->where('banom_officers.nama', 'like', "%{$search}%")
                      ->orWhereHas('member', function ($m) use ($search) {
                          $m->where('nama_lengkap', 'like', "%{$search}%");
                      });
                });
            }

            $prnuOfficers = $prnuQuery->get();
        }

        // Fallback jika belum ada di banom_officers tetapi ada di organization_structures
        $legacyStructures = collect();
        if ($prnuOfficers->isEmpty()) {
            $legacyQuery = OrganizationStructure::with('banom')
                ->where('status', 'Aktif')
                ->orderBy('urutan');

            if ($search) {
                $legacyQuery->where(function ($q) use ($search) {
                    $q->where('nama', 'LIKE', "%{$search}%")
                      ->orWhere('jabatan', 'LIKE', "%{$search}%");
                });
            }
            $legacyStructures = $legacyQuery->get();
        }

        // Kelompokkan PRNU Officers
        $mustasyarOfficers = $prnuOfficers->filter(function ($o) {
            return $o->position && $o->position->kategori === 'Mustasyar';
        });

        $syuriyahHarianOfficers = $prnuOfficers->filter(function ($o) {
            return $o->position && $o->position->kategori === 'Syuriyah' && in_array($o->position->tipe, ['inti', 'wakil']) && !str_contains($o->position->nama, "A'wan");
        });

        $awanOfficers = $prnuOfficers->filter(function ($o) {
            return $o->position && $o->position->kategori === 'Syuriyah' && str_contains($o->position->nama, "A'wan");
        });

        $tanfidziyahOfficers = $prnuOfficers->filter(function ($o) {
            return $o->position && $o->position->kategori === 'Tanfidziyah';
        });

        // 3. PENGURUS PLENO RANTING
        // Gabungan otomatis: Pengurus Lengkap Syuriyah + Pengurus Harian Tanfidziyah + Seluruh Ketua Banom
        $plenoSyuriyah = $prnuOfficers->filter(function ($o) {
            return $o->position && $o->position->kategori === 'Syuriyah';
        });

        $plenoTanfidziyah = $prnuOfficers->filter(function ($o) {
            return $o->position && $o->position->kategori === 'Tanfidziyah';
        });

        // Seluruh Ketua Banom
        $plenoKetuaBanom = collect();
        foreach ($banoms as $banomItem) {
            $ketuaOfficer = $banomItem->officers->first(function ($officer) {
                $posName = strtolower($officer->position->nama ?? '');
                return in_array($posName, ['ketua', 'kepala satkorkel (kasatkorkel)', 'kasatkorkel']) 
                    || ($officer->position->tipe === 'inti' && str_contains($posName, 'ketua'));
            });

            if ($ketuaOfficer) {
                $plenoKetuaBanom->push([
                    'banom' => $banomItem,
                    'officer' => $ketuaOfficer,
                ]);
            }
        }

        return view('structure.index', compact(
            'profile',
            'tab',
            'search',
            'banoms',
            'prnu',
            'prnuOfficers',
            'legacyStructures',
            'mustasyarOfficers',
            'syuriyahHarianOfficers',
            'awanOfficers',
            'tanfidziyahOfficers',
            'plenoSyuriyah',
            'plenoTanfidziyah',
            'plenoKetuaBanom'
        ));
    }
}
