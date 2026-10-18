<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banom;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index(Request $request)
    {
        $banoms = Banom::where('is_active', true)->orderBy('urutan')->get();
        $selectedBanomId = $request->query('banom_id', $banoms->first()?->id);

        $selectedBanom = $selectedBanomId ? Banom::find($selectedBanomId) : $banoms->first();

        $divisions = [];
        if ($selectedBanom) {
            $divisions = $selectedBanom->divisions()
                ->withCount(['officers' => function ($q) {
                    $q->where('is_active', true);
                }])
                ->orderBy('urutan')
                ->get();
        }

        return view('admin.division.index', compact('banoms', 'selectedBanom', 'divisions'));
    }

    public function create(Request $request)
    {
        $banoms = Banom::where('is_active', true)->orderBy('urutan')->get();
        $selectedBanomId = $request->query('banom_id', $banoms->first()?->id);
        $selectedBanom = $selectedBanomId ? Banom::find($selectedBanomId) : $banoms->first();
        $nextUrutan = $selectedBanom ? ($selectedBanom->divisions()->max('urutan') ?? 0) + 1 : 1;

        return view('admin.division.create', compact('banoms', 'selectedBanom', 'nextUrutan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'banom_id' => 'required|exists:banoms,id',
            'nama' => 'required|string|max:255',
            'urutan' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string|max:1000',
        ], [
            'banom_id.required' => 'Pilih Badan Otonom / Organisasi.',
            'nama.required' => 'Nama bidang/departemen/seksi wajib diisi.',
            'urutan.integer' => 'Urutan harus berupa angka.',
        ]);

        $validated['urutan'] = $validated['urutan'] ?? 0;

        $division = Division::create($validated);

        return redirect()->route('admin.divisions.index', ['banom_id' => $division->banom_id])
            ->with('success', "Bagian '{$division->nama}' berhasil ditambahkan ke {$division->banom->singkatan}.");
    }

    public function edit(Division $division)
    {
        $banoms = Banom::where('is_active', true)->orderBy('urutan')->get();
        $activeOfficersCount = $division->officers()->where('is_active', true)->count();

        return view('admin.division.edit', compact('division', 'banoms', 'activeOfficersCount'));
    }

    public function update(Request $request, Division $division)
    {
        $validated = $request->validate([
            'banom_id' => 'required|exists:banoms,id',
            'nama' => 'required|string|max:255',
            'urutan' => 'nullable|integer|min:0',
            'deskripsi' => 'nullable|string|max:1000',
        ], [
            'banom_id.required' => 'Pilih Badan Otonom / Organisasi.',
            'nama.required' => 'Nama bidang/departemen/seksi wajib diisi.',
            'urutan.integer' => 'Urutan harus berupa angka.',
        ]);

        $validated['urutan'] = $validated['urutan'] ?? 0;

        $division->update($validated);

        return redirect()->route('admin.divisions.index', ['banom_id' => $division->banom_id])
            ->with('success', "Bagian '{$division->nama}' berhasil diperbarui.");
    }

    public function destroy(Division $division)
    {
        $officersCount = $division->officers()->count();
        if ($officersCount > 0) {
            return redirect()->route('admin.divisions.index', ['banom_id' => $division->banom_id])
                ->with('error', "Bagian '{$division->nama}' tidak dapat dihapus karena masih terdapat {$officersCount} pengurus terdaftar di dalamnya.");
        }

        $banomId = $division->banom_id;
        $nama = $division->nama;
        $division->delete();

        return redirect()->route('admin.divisions.index', ['banom_id' => $banomId])
            ->with('success', "Bagian '{$nama}' berhasil dihapus.");
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:divisions,id',
            'orders.*.urutan' => 'required|integer',
        ]);

        foreach ($request->orders as $item) {
            Division::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
        }

        return back()->with('success', 'Urutan bagian berhasil diperbarui.');
    }
}
