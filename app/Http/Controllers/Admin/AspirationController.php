<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspiration;
use Illuminate\Http\Request;

class AspirationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $kategori = $request->query('kategori');
        $search = $request->query('q');

        $query = Aspiration::latest();

        if ($status) {
            $query->where('status', $status);
        }

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_tiket', 'LIKE', "%{$search}%")
                  ->orWhere('nama', 'LIKE', "%{$search}%")
                  ->orWhere('subjek', 'LIKE', "%{$search}%")
                  ->orWhere('pesan', 'LIKE', "%{$search}%");
            });
        }

        $aspirations = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Aspiration::count(),
            'baru' => Aspiration::where('status', 'Baru')->count(),
            'dibaca' => Aspiration::where('status', 'Dibaca')->count(),
            'diproses' => Aspiration::where('status', 'Diproses')->count(),
            'selesai' => Aspiration::where('status', 'Selesai')->count(),
        ];

        return view('admin.aspiration.index', compact('aspirations', 'status', 'kategori', 'search', 'stats'));
    }

    public function show(Aspiration $aspirasi)
    {
        // Mark as Dibaca if currently Baru
        if ($aspirasi->status === 'Baru') {
            $aspirasi->update(['status' => 'Dibaca']);
        }

        return view('admin.aspiration.show', ['aspiration' => $aspirasi]);
    }

    public function updateStatus(Request $request, Aspiration $aspirasi)
    {
        $validated = $request->validate([
            'status' => 'required|in:Baru,Dibaca,Diproses,Selesai',
            'catatan_admin' => 'nullable|string',
        ]);

        $aspirasi->update($validated);

        return back()->with('success', 'Status aspirasi warga berhasil diperbarui.');
    }

    public function destroy(Aspiration $aspirasi)
    {
        $aspirasi->delete();
        return redirect()->route('admin.aspirasi.index')->with('success', 'Data aspirasi berhasil dihapus.');
    }
}
