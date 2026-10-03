@extends('layouts.admin')

@section('title', 'Dashboard Utama — SIMNU Portal PRNU Banjaranyar')

@section('content')
<div class="space-y-8">
    
    <!-- Welcome Header & Quick Action Buttons -->
    <div class="bg-gradient-to-r from-[#004125] to-[#0c5a37] rounded-3xl p-6 sm:p-8 text-white shadow-lg shadow-emerald-950/20 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 rounded-full bg-emerald-500/10 blur-2xl pointer-events-none"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#aaf2c4_1px,transparent_1px)] [background-size:20px_20px] opacity-10 pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="space-y-2 max-w-2xl">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold uppercase tracking-wider bg-white/10 text-[#aaf2c4] border border-white/10">
                        Portal Administrasi Resmi
                    </span>
                    <span class="text-xs text-emerald-200">{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">Ahlan wa Sahlan, {{ Auth::user()->name ?? 'Pengurus NU' }}!</h1>
                <p class="text-xs sm:text-sm text-emerald-100 leading-relaxed">
                    Sistem Informasi Manajemen Nahdlatul Ulama (SIMNU) Ranting Desa Banjaranyar. Kelola database 5 BANOM, legalitas kader, penerbitan KTA digital ber-QR Code, serta warta organisasi dalam satu komando terpadu.
                </p>
            </div>

            <!-- Quick Action Shortcuts -->
            <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                <a href="{{ route('admin.anggota.create') }}" class="px-3.5 py-2.5 rounded-xl bg-white text-[#004125] hover:bg-emerald-50 text-xs font-bold transition flex items-center gap-1.5 shadow-md">
                    <span class="material-symbols-outlined text-[16px] text-emerald-700">person_add</span>
                    <span>Tambah Anggota</span>
                </a>
                <a href="{{ route('admin.kta.bulk-print') }}" class="px-3.5 py-2.5 rounded-xl bg-[#fe932c] hover:bg-[#e07e1e] text-white text-xs font-bold transition flex items-center gap-1.5 shadow-md">
                    <span class="material-symbols-outlined text-[16px]">print</span>
                    <span>Cetak KTA Massal</span>
                </a>
                <a href="{{ route('admin.berita.create') }}" class="px-3.5 py-2.5 rounded-xl bg-white/15 hover:bg-white/20 text-white border border-white/20 text-xs font-bold transition flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">edit_note</span>
                    <span>Tulis Warta</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 6 Key Performance Metric Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-5">
        
        <!-- Total Anggota -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#e6eeff] shadow-sm hover:border-emerald-300 transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#526350]">Total Kader</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-[#004125] flex items-center justify-center">
                    <span class="material-symbols-outlined text-[18px]">groups</span>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-black text-[#004125]">{{ number_format($totalAnggota) }}</div>
                <div class="text-[11px] text-gray-500 font-medium mt-0.5">Basis 5 BANOM</div>
            </div>
        </div>

        <!-- Total KTA -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#e6eeff] shadow-sm hover:border-emerald-300 transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#526350]">KTA Diterbitkan</span>
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[18px]">id_card</span>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-black text-blue-900">{{ number_format($totalKta) }}</div>
                <div class="text-[11px] text-emerald-700 font-semibold mt-0.5 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span>{{ $ktaAktif }} Aktif</span>
                </div>
            </div>
        </div>

        <!-- Total Pengurus -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#e6eeff] shadow-sm hover:border-emerald-300 transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#526350]">Struktur Amanah</span>
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[18px]">badge</span>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-black text-indigo-950">{{ number_format($totalPengurus) }}</div>
                <div class="text-[11px] text-gray-500 font-medium mt-0.5">Pengurus Ranting</div>
            </div>
        </div>

        <!-- 5 BANOM -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#e6eeff] shadow-sm hover:border-emerald-300 transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#526350]">Badan Otonom</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[18px]">account_tree</span>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-black text-amber-950">{{ $totalBanom }}</div>
                <div class="text-[11px] text-gray-500 font-medium mt-0.5">IPNU, FATAYAT, dll</div>
            </div>
        </div>

        <!-- Total Warta & Agenda -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#e6eeff] shadow-sm hover:border-emerald-300 transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#526350]">Publikasi</span>
                <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-700 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[18px]">newspaper</span>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-black text-teal-950">{{ number_format($totalBerita) }}</div>
                <div class="text-[11px] text-gray-500 font-medium mt-0.5">{{ $totalAgenda }} Agenda</div>
            </div>
        </div>

        <!-- Aspirasi Masyarakat -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#e6eeff] shadow-sm hover:border-emerald-300 transition-all flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold uppercase tracking-wider text-[#526350]">Aspirasi Warga</span>
                <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-700 flex items-center justify-center">
                    <span class="material-symbols-outlined text-[18px]">forum</span>
                </div>
            </div>
            <div class="mt-3">
                <div class="text-2xl font-black text-rose-950">{{ number_format($totalAspirasi) }}</div>
                <div class="text-[11px] {{ $aspirasiBaru > 0 ? 'text-rose-600 font-bold' : 'text-gray-500' }} mt-0.5 flex items-center gap-1">
                    @if($aspirasiBaru > 0)
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-pulse"></span>
                    @endif
                    <span>{{ $aspirasiBaru }} Perlu Ditinjau</span>
                </div>
            </div>
        </div>

    </div>

    <!-- BANOM Overview Statistics Grid -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-[#e6eeff] pb-4">
            <div>
                <h2 class="text-lg font-bold text-[#004125] flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600">account_balance</span>
                    <span>Statistik 5 Badan Otonom (BANOM) Nahdlatul Ulama</span>
                </h2>
                <p class="text-xs text-[#526350]">Ringkasan jumlah kader dan pencapaian KTA terbit pada masing-masing sayap organisasi</p>
            </div>
            <a href="{{ route('admin.banom.index') }}" class="text-xs font-bold text-[#0c5a37] hover:underline flex items-center gap-1">
                <span>Kelola BANOM</span>
                <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            @foreach($banoms as $banom)
                @php
                    $ktaCount = $ktaPerBanom[$banom->singkatan] ?? 0;
                    $percentKta = $banom->members_count > 0 ? round(($ktaCount / $banom->members_count) * 100) : 0;
                @endphp
                <div class="rounded-2xl border border-gray-100 bg-[#fbfcfe] p-4.5 space-y-3.5 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-white border border-gray-200 flex items-center justify-center p-1 text-[#004125] font-black text-xs shadow-sm">
                                @if($banom->logo)
                                    <img src="{{ asset('storage/' . $banom->logo) }}" alt="{{ $banom->singkatan }}" class="w-full h-full object-contain">
                                @else
                                    {{ substr($banom->singkatan, 0, 3) }}
                                @endif
                            </div>
                            <div>
                                <h3 class="text-sm font-extrabold text-[#004125]">{{ $banom->singkatan }}</h3>
                                <p class="text-[10px] text-gray-500 line-clamp-1">{{ $banom->nama }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1.5 pt-1 border-t border-gray-100 text-xs">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 text-[11px]">Kader Terdata:</span>
                            <span class="font-bold text-gray-900">{{ $banom->members_count }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 text-[11px]">KTA Terbit:</span>
                            <span class="font-bold text-emerald-800">{{ $ktaCount }} ({{ $percentKta }}%)</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500 text-[11px]">Pengurus:</span>
                            <span class="font-semibold text-gray-700">{{ $banom->organization_structures_count }}</span>
                        </div>
                    </div>

                    <!-- Mini progress bar -->
                    <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-[#0c5a37] h-1.5 rounded-full" style="width: {{ min(100, $percentKta) }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 2 Column Layout: Recent Members / KTA (7 cols) + Recent Aspirations & Events (5 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Column: Anggota & KTA Terkini (7 cols) -->
        <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-[#e6eeff] shadow-sm space-y-5">
            <div class="flex items-center justify-between border-b border-[#e6eeff] pb-4">
                <div>
                    <h3 class="text-base font-bold text-[#004125] flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600">person_search</span>
                        <span>Pendaftaran Anggota & Status KTA Terkini</span>
                    </h3>
                    <p class="text-xs text-[#526350]">Daftar kader terbaru yang terdaftar dalam sistem informasi</p>
                </div>
                <a href="{{ route('admin.anggota.index') }}" class="text-xs font-bold text-[#0c5a37] hover:underline flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-gray-100 text-[#526350] font-bold uppercase tracking-wider text-[10px]">
                            <th class="py-2.5 px-3">Nama Kader</th>
                            <th class="py-2.5 px-3">BANOM</th>
                            <th class="py-2.5 px-3">Status KTA</th>
                            <th class="py-2.5 px-3 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($recentMembers as $m)
                            <tr class="hover:bg-gray-50/70 transition">
                                <td class="py-3 px-3">
                                    <div class="font-bold text-gray-900">{{ $m->nama_lengkap }}</div>
                                    <div class="text-[10px] text-gray-400 font-mono">{{ $m->nomor_anggota }}</div>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-[#004125]">
                                        {{ $m->banom->singkatan ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3 px-3">
                                    @if($m->kta)
                                        <div class="flex items-center gap-1">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                                <span class="material-symbols-outlined text-[12px] text-emerald-600">check_circle</span>
                                                <span>{{ $m->kta->nomor_kta }}</span>
                                            </span>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-600">
                                            <span class="material-symbols-outlined text-[12px]">pending</span>
                                            <span>Belum Ada KTA</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-right">
                                    @if($m->kta)
                                        <a href="{{ route('admin.kta.show', $m->kta->id) }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 hover:text-emerald-900 bg-emerald-50 px-2 py-1 rounded-lg">
                                            <span class="material-symbols-outlined text-[14px]">id_card</span>
                                            <span>Lihat KTA</span>
                                        </a>
                                    @else
                                        <form action="{{ route('admin.kta.generate', $m->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1 text-[11px] font-bold text-white bg-[#0c5a37] hover:bg-[#004125] px-2.5 py-1 rounded-lg shadow-sm">
                                                <span class="material-symbols-outlined text-[14px]">auto_fix_high</span>
                                                <span>Generate</span>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-400">Belum ada data anggota yang terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Column: Aspirasi & Agenda (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Aspirasi Masuk -->
            <div class="bg-white rounded-3xl p-6 border border-[#e6eeff] shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-[#e6eeff] pb-3">
                    <h3 class="text-sm font-bold text-[#004125] flex items-center gap-2">
                        <span class="material-symbols-outlined text-rose-600">forum</span>
                        <span>Aspirasi Masyarakat Terkini</span>
                    </h3>
                    <a href="{{ route('admin.aspirasi.index') }}" class="text-[11px] font-bold text-[#0c5a37] hover:underline">
                        Lihat Semua
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($recentAspirations as $asp)
                        <a href="{{ route('admin.aspirasi.show', $asp->id) }}" class="block p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition border border-gray-100 space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-900 truncate max-w-[180px]">{{ $asp->nama }}</span>
                                <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded-full {{ $asp->status === 'Baru' ? 'bg-rose-100 text-rose-800' : 'bg-gray-200 text-gray-700' }}">
                                    {{ $asp->status }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-600 line-clamp-1 font-medium">{{ $asp->subjek }}</p>
                            <div class="text-[10px] text-gray-400 flex items-center justify-between pt-0.5">
                                <span>{{ $asp->kategori }}</span>
                                <span>{{ $asp->created_at->diffForHumans() }}</span>
                            </div>
                        </a>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">Belum ada aspirasi masyarakat yang masuk.</p>
                    @endforelse
                </div>
            </div>

            <!-- Agenda Mendatang -->
            <div class="bg-white rounded-3xl p-6 border border-[#e6eeff] shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-[#e6eeff] pb-3">
                    <h3 class="text-sm font-bold text-[#004125] flex items-center gap-2">
                        <span class="material-symbols-outlined text-teal-600">event</span>
                        <span>Agenda Ranting Mendatang</span>
                    </h3>
                    <a href="{{ route('admin.agenda.index') }}" class="text-[11px] font-bold text-[#0c5a37] hover:underline">
                        Semua Agenda
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($upcomingEvents as $ev)
                        <div class="p-3 rounded-xl bg-[#f0fbf6] border border-emerald-100 space-y-1">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-bold text-[#004125] line-clamp-1">{{ $ev->title }}</span>
                                <span class="text-[10px] text-emerald-700 font-semibold shrink-0">{{ $ev->tanggal->format('d M') }}</span>
                            </div>
                            <div class="text-[11px] text-[#526350] flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[13px] text-emerald-600">location_on</span>
                                <span class="truncate">{{ $ev->lokasi }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">Belum ada agenda mendatang yang dijadwalkan.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
