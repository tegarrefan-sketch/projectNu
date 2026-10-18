<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Position\StorePositionRequest;
use App\Http\Requests\Admin\Position\UpdatePositionRequest;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index(Request $request)
    {
        $query = Position::with(['banomOfficers' => function ($q) {
            $q->where('is_active', true);
        }]);

        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where('nama', 'like', "%{$q}%");
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        $positions = $query->orderBy('urutan_hierarki')->orderBy('urutan')->orderBy('id')->paginate(20)->withQueryString();
        $categories = ['Mustasyar', 'Syuriyah', 'Tanfidziyah', 'Banom', 'Bidang'];
        $types = ['inti' => 'Pimpinan Inti', 'wakil' => 'Wakil Pimpinan', 'anggota' => 'Anggota / Pasukan'];

        return view('admin.position.index', compact('positions', 'categories', 'types'));
    }

    public function create()
    {
        $categories = ['Mustasyar', 'Syuriyah', 'Tanfidziyah', 'Banom', 'Bidang'];
        $types = ['inti' => 'Pimpinan Inti', 'wakil' => 'Wakil Pimpinan', 'anggota' => 'Anggota / Pasukan'];
        $nextUrutan = (Position::max('urutan') ?? 0) + 1;

        return view('admin.position.create', compact('categories', 'types', 'nextUrutan'));
    }

    public function store(StorePositionRequest $request)
    {
        $validated = $request->validated();
        $validated['urutan'] = $validated['urutan'] ?? 0;
        $validated['batas_keras'] = $request->boolean('batas_keras');
        $validated['maks_orang'] = !empty($validated['maks_orang']) ? (int) $validated['maks_orang'] : null;
        $validated['anjuran_maks'] = !empty($validated['anjuran_maks']) ? (int) $validated['anjuran_maks'] : null;

        $position = Position::create($validated);

        return redirect()->route('admin.positions.index')
            ->with('success', "Jabatan {$position->nama} berhasil ditambahkan.");
    }

    public function edit(Position $position)
    {
        $categories = ['Mustasyar', 'Syuriyah', 'Tanfidziyah', 'Banom', 'Bidang'];
        $types = ['inti' => 'Pimpinan Inti', 'wakil' => 'Wakil Pimpinan', 'anggota' => 'Anggota / Pasukan'];
        $activeOfficersCount = $position->banomOfficers()->where('is_active', true)->count();
        
        // Hitung pengurus aktif terbanyak dalam 1 banom
        $maxPerBanom = $position->banomOfficers()
            ->reorder()
            ->where('is_active', true)
            ->groupBy('banom_id')
            ->selectRaw('count(*) as count')
            ->pluck('count')
            ->max() ?? 0;

        $banomCount = $position->banomOfficers()
            ->where('is_active', true)
            ->distinct('banom_id')
            ->count('banom_id');

        return view('admin.position.edit', compact('position', 'categories', 'types', 'activeOfficersCount', 'maxPerBanom', 'banomCount'));
    }

    public function update(UpdatePositionRequest $request, Position $position)
    {
        $validated = $request->validated();
        $validated['batas_keras'] = $request->boolean('batas_keras');
        $validated['maks_orang'] = !empty($validated['maks_orang']) ? (int) $validated['maks_orang'] : null;
        $validated['anjuran_maks'] = !empty($validated['anjuran_maks']) ? (int) $validated['anjuran_maks'] : null;
        
        $maxPerBanom = $position->banomOfficers()
            ->reorder()
            ->where('is_active', true)
            ->groupBy('banom_id')
            ->selectRaw('count(*) as count')
            ->pluck('count')
            ->max() ?? 0;

        $warning = null;
        if (!empty($validated['maks_orang']) && $validated['maks_orang'] < $maxPerBanom) {
            $warning = "Perhatian: Maksimal orang ({$validated['maks_orang']}) lebih kecil dari jumlah pengurus aktif terbanyak dalam satu badan otonom ({$maxPerBanom} orang).";
        }

        $position->update($validated);

        $response = redirect()->route('admin.positions.index')
            ->with('success', "Jabatan {$position->nama} berhasil diperbarui.");

        if ($warning) {
            $response->with('warning', $warning);
        }

        return $response;
    }

    public function destroy(Position $position)
    {
        $officersCount = $position->banomOfficers()->count();
        if ($officersCount > 0) {
            return redirect()->route('admin.positions.index')
                ->with('error', "Jabatan {$position->nama} tidak dapat dihapus karena masih digunakan oleh {$officersCount} pengurus.");
        }

        $nama = $position->nama;
        $position->delete();

        return redirect()->route('admin.positions.index')
            ->with('success', "Jabatan {$nama} berhasil dihapus.");
    }
}
