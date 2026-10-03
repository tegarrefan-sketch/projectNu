<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banom;
use App\Models\OrganizationStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationStructureController extends Controller
{
    public function index(Request $request)
    {
        $banoms = Banom::orderBy('urutan')->get();
        $banomId = $request->query('banom_id');
        $hierarki = $request->query('hierarki');

        $query = OrganizationStructure::with('banom')->orderBy('urutan');

        if ($banomId !== null && $banomId !== '') {
            if ($banomId === 'prnu') {
                $query->whereNull('banom_id');
            } else {
                $query->where('banom_id', $banomId);
            }
        }

        if ($hierarki) {
            $query->where('kategori_hierarki', $hierarki);
        }

        $structures = $query->paginate(15)->withQueryString();

        return view('admin.structure.index', compact('structures', 'banoms', 'banomId', 'hierarki'));
    }

    public function create()
    {
        $banoms = Banom::where('status', 'Aktif')->orderBy('urutan')->get();
        return view('admin.structure.create', compact('banoms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'banom_id' => 'nullable|exists:banoms,id',
            'kategori_hierarki' => 'required|in:mustasyar,syuriyah,tanfidziyah,lembaga,banom',
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'nama.required' => 'Nama pengurus wajib diisi.',
            'jabatan.required' => 'Amanah / Jabatan pengurus wajib diisi.',
            'kategori_hierarki.required' => 'Pilih kategori hierarki kepengurusan.',
        ]);

        $validated['urutan'] = $validated['urutan'] ?? 0;

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('pengurus', 'public');
        }

        OrganizationStructure::create($validated);

        return redirect()->route('admin.struktur.index')->with('success', 'Data pengurus berhasil ditambahkan.');
    }

    public function edit(OrganizationStructure $struktur)
    {
        $banoms = Banom::where('status', 'Aktif')->orderBy('urutan')->get();
        return view('admin.structure.edit', compact('struktur', 'banoms'));
    }

    public function update(Request $request, OrganizationStructure $struktur)
    {
        $validated = $request->validate([
            'banom_id' => 'nullable|exists:banoms,id',
            'kategori_hierarki' => 'required|in:mustasyar,syuriyah,tanfidziyah,lembaga,banom',
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($struktur->foto && Storage::disk('public')->exists($struktur->foto)) {
                Storage::disk('public')->delete($struktur->foto);
            }
            $validated['foto'] = $request->file('foto')->store('pengurus', 'public');
        }

        $struktur->update($validated);

        return redirect()->route('admin.struktur.index')->with('success', 'Data pengurus berhasil diperbarui.');
    }

    public function destroy(OrganizationStructure $struktur)
    {
        $struktur->delete();
        return redirect()->route('admin.struktur.index')->with('success', 'Data pengurus berhasil dihapus.');
    }
}
