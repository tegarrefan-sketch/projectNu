<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Banom\StoreBanomRequest;
use App\Http\Requests\Admin\Banom\UpdateBanomRequest;
use App\Models\Banom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BanomController extends Controller
{
    public function index(Request $request)
    {
        $query = Banom::withCount(['banomOfficers', 'members']);

        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($w) use ($q) {
                $w->where('nama', 'like', "%{$q}%")
                  ->orWhere('singkatan', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'aktif') {
                $query->where('is_active', true);
            } elseif ($request->status === 'nonaktif') {
                $query->where('is_active', false);
            }
        }

        $sort = $request->input('sort', 'urutan');
        $direction = $request->input('direction', 'asc');
        if (in_array($sort, ['urutan', 'nama', 'singkatan', 'created_at'])) {
            $query->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');
        } else {
            $query->orderBy('urutan');
        }

        $banoms = $query->paginate(10)->withQueryString();

        return view('admin.banom.index', compact('banoms'));
    }

    public function create()
    {
        $nextUrutan = (Banom::max('urutan') ?? 0) + 1;
        return view('admin.banom.create', compact('nextUrutan'));
    }

    public function store(StoreBanomRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['singkatan']);
        $validated['urutan'] = $validated['urutan'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['status'] = $validated['is_active'] ? 'Aktif' : 'Tidak Aktif';

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('banom_logos', 'public');
        }

        $banom = Banom::create($validated);

        return redirect()->route('admin.banoms.index')
            ->with('success', "Badan Otonom {$banom->singkatan} berhasil ditambahkan.");
    }

    public function show(Banom $banom)
    {
        $banom->load([
            'banomOfficers' => function ($q) {
                $q->with(['position', 'member'])
                  ->join('positions', 'banom_officers.position_id', '=', 'positions.id')
                  ->orderBy('positions.urutan')
                  ->orderBy('banom_officers.urutan')
                  ->select('banom_officers.*');
            }
        ]);

        // Group officers by position name for hierarchical view
        $groupedOfficers = $banom->banomOfficers->groupBy(function ($officer) {
            return $officer->position->nama ?? 'Tanpa Jabatan';
        });

        return view('admin.banom.show', compact('banom', 'groupedOfficers'));
    }

    public function edit(Banom $banom)
    {
        return view('admin.banom.edit', compact('banom'));
    }

    public function update(UpdateBanomRequest $request, Banom $banom)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['singkatan']);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['status'] = $validated['is_active'] ? 'Aktif' : 'Tidak Aktif';

        if ($request->hasFile('logo')) {
            if ($banom->logo && Storage::disk('public')->exists($banom->logo)) {
                Storage::disk('public')->delete($banom->logo);
            }
            $validated['logo'] = $request->file('logo')->store('banom_logos', 'public');
        }

        $banom->update($validated);

        return redirect()->route('admin.banoms.index')
            ->with('success', "Data Badan Otonom {$banom->singkatan} berhasil diperbarui.");
    }

    public function destroy(Banom $banom)
    {
        $singkatan = $banom->singkatan;

        if ($banom->logo && Storage::disk('public')->exists($banom->logo)) {
            Storage::disk('public')->delete($banom->logo);
        }

        // Delete any custom officer photos
        foreach ($banom->banomOfficers as $officer) {
            if ($officer->foto && Storage::disk('public')->exists($officer->foto)) {
                Storage::disk('public')->delete($officer->foto);
            }
        }

        $banom->delete();

        return redirect()->route('admin.banoms.index')
            ->with('success', "Badan Otonom {$singkatan} beserta jajaran pengurusnya berhasil dihapus.");
    }
}
