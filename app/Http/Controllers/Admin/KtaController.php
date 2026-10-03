<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banom;
use App\Models\Kta;
use App\Models\Member;
use App\Services\QrCodeService;
use Illuminate\Http\Request;

class KtaController extends Controller
{
    public function index(Request $request)
    {
        $banoms = Banom::orderBy('urutan')->get();
        $banomId = $request->query('banom_id');
        $status = $request->query('status');
        $year = $request->query('year');
        $search = $request->query('q');

        $query = Kta::with(['member.banom'])->latest();

        if ($banomId) {
            $query->whereHas('member', function ($q) use ($banomId) {
                $q->where('banom_id', $banomId);
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($year) {
            $query->whereYear('tanggal_terbit', $year);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nomor_kta', 'LIKE', "%{$search}%")
                  ->orWhereHas('member', function ($mq) use ($search) {
                      $mq->where('nama_lengkap', 'LIKE', "%{$search}%")
                         ->orWhere('nomor_anggota', 'LIKE', "%{$search}%");
                  });
            });
        }

        $ktas = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Kta::count(),
            'aktif' => Kta::where('status', 'Aktif')->count(),
            'tidak_aktif' => Kta::where('status', 'Tidak Aktif')->count(),
            'kadaluarsa' => Kta::where('status', 'Kadaluarsa')->count(),
        ];

        // Member without KTA count
        $unassignedMembersCount = Member::doesntHave('kta')->where('status', 'Aktif')->count();

        return view('admin.kta.index', compact('ktas', 'banoms', 'banomId', 'status', 'year', 'search', 'stats', 'unassignedMembersCount'));
    }

    public function generate(int $memberId)
    {
        $member = Member::with('banom')->findOrFail($memberId);

        if ($member->kta()->exists()) {
            return redirect()->route('admin.kta.show', $member->kta->id)->with('info', 'Anggota ini sudah memiliki KTA.');
        }

        $nomorKta = Kta::generateKtaNumber($member);
        $verifyUrl = url("/kta/verify/{$nomorKta}");
        $qrDataUri = QrCodeService::generateDataUri($verifyUrl);

        $kta = Kta::create([
            'member_id' => $member->id,
            'nomor_kta' => $nomorKta,
            'tanggal_terbit' => now()->toDateString(),
            'tanggal_berlaku' => now()->addYears(3)->toDateString(),
            'status' => 'Aktif',
            'qr_code_svg' => $qrDataUri,
            'keterangan' => 'KTA Diterbitkan melalui SIMNU Admin Console',
        ]);

        return redirect()->route('admin.kta.show', $kta->id)->with('success', "KTA {$nomorKta} berhasil dibuat untuk {$member->nama_lengkap}.");
    }

    public function show(Kta $ktum)
    {
        $ktum->load(['member.banom']);
        
        // Ensure QR code exists
        if (empty($ktum->qr_code_svg)) {
            $verifyUrl = url("/kta/verify/{$ktum->nomor_kta}");
            $ktum->update([
                'qr_code_svg' => QrCodeService::generateDataUri($verifyUrl)
            ]);
        }

        return view('admin.kta.show', ['kta' => $ktum]);
    }

    public function print(Kta $ktum)
    {
        $ktum->load(['member.banom']);

        if (empty($ktum->qr_code_svg)) {
            $verifyUrl = url("/kta/verify/{$ktum->nomor_kta}");
            $ktum->update([
                'qr_code_svg' => QrCodeService::generateDataUri($verifyUrl)
            ]);
        }

        return view('admin.kta.print', ['kta' => $ktum]);
    }

    public function downloadPdf(Kta $ktum)
    {
        $ktum->load(['member.banom']);

        return view('admin.kta.download', ['kta' => $ktum]);
    }

    public function bulkPrint(Request $request)
    {
        $ids = $request->input('kta_ids', []);

        if (empty($ids) && $request->filled('banom_id')) {
            $ids = Kta::whereHas('member', function ($q) use ($request) {
                $q->where('banom_id', $request->banom_id);
            })->where('status', 'Aktif')->pluck('id')->toArray();
        }

        if (empty($ids)) {
            return redirect()->route('admin.kta.index')->with('error', 'Pilih minimal satu KTA untuk dicetak massal.');
        }

        $ktas = Kta::with(['member.banom'])->whereIn('id', $ids)->get();

        foreach ($ktas as $kta) {
            if (empty($kta->qr_code_svg)) {
                $verifyUrl = url("/kta/verify/{$kta->nomor_kta}");
                $kta->update([
                    'qr_code_svg' => QrCodeService::generateDataUri($verifyUrl)
                ]);
            }
        }

        return view('admin.kta.bulk-print', compact('ktas'));
    }

    public function updateStatus(Request $request, Kta $ktum)
    {
        $validated = $request->validate([
            'status' => 'required|in:Aktif,Tidak Aktif,Kadaluarsa',
        ]);

        $ktum->update($validated);

        return back()->with('success', 'Status KTA berhasil diperbarui.');
    }

    public function destroy(Kta $ktum)
    {
        $ktum->delete();
        return redirect()->route('admin.kta.index')->with('success', 'KTA berhasil dicabut / dinonaktifkan.');
    }
}
