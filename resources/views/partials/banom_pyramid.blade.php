@php
    $allPersons = collect();

    if (isset($officers) && $officers->isNotEmpty()) {
        foreach ($officers as $off) {
            $posName = $off->position->nama ?? 'Pengurus';
            $allPersons->push((object)[
                'nama' => $off->display_nama,
                'jabatan' => $posName,
                'sub_jabatan' => $off->division->nama ?? ($off->bidang ?? null),
                'foto' => $off->display_foto,
                'nia' => $off->member->nomor_anggota ?? null,
                'raw' => $off
            ]);
        }
    } elseif (isset($structures) && $structures->isNotEmpty()) {
        foreach ($structures as $st) {
            $allPersons->push((object)[
                'nama' => $st->nama,
                'jabatan' => $st->jabatan ?? 'Pengurus',
                'sub_jabatan' => $st->deskripsi ?? null,
                'foto' => $st->foto ? asset('storage/' . $st->foto) : null,
                'nia' => null,
                'raw' => $st
            ]);
        }
    }

    // 1. Tier Puncak (Ketua / Pimpinan Tertinggi)
    $tierPuncak = $allPersons->filter(function($p) {
        $j = strtolower($p->jabatan);
        return (str_contains($j, 'ketua') || str_contains($j, 'kasatkorkel') || str_contains($j, 'kepala') || str_contains($j, 'komandan'))
            && !str_contains($j, 'wakil')
            && !str_contains($j, 'bidang')
            && !str_contains($j, 'seksi')
            && !str_contains($j, 'departemen');
    });

    // 2. Tier Wakil Pimpinan
    $tierWakil = $allPersons->filter(function($p) {
        $j = strtolower($p->jabatan);
        return str_contains($j, 'wakil ketua') || str_contains($j, 'wakil kasatkorkel') || str_contains($j, 'wakil kepala') || str_contains($j, 'wakil komandan');
    });

    // 3. Tier Sekretaris & Bendahara (Pengurus Harian Inti)
    $tierSekretariatBendahara = $allPersons->filter(function($p) {
        $j = strtolower($p->jabatan);
        return (str_contains($j, 'sekretaris') || str_contains($j, 'bendahara'))
            && !str_contains($j, 'bidang')
            && !str_contains($j, 'departemen');
    });

    // 4. Tier Bidang / Departemen / Divisi
    $tierBidang = $allPersons->filter(function($p) {
        $j = strtolower($p->jabatan);
        return str_contains($j, 'bidang') || str_contains($j, 'departemen') || str_contains($j, 'divisi') || str_contains($j, 'seksi') || str_contains($j, 'koordinator') || !empty($p->sub_jabatan);
    })->reject(function($p) use ($tierPuncak, $tierWakil, $tierSekretariatBendahara) {
        return $tierPuncak->contains($p) || $tierWakil->contains($p) || $tierSekretariatBendahara->contains($p);
    });

    // 5. Tier Anggota / Kader Lainnya
    $assigned = $tierPuncak->merge($tierWakil)->merge($tierSekretariatBendahara)->merge($tierBidang);
    $tierAnggota = $allPersons->reject(function($p) use ($assigned) {
        return $assigned->contains($p);
    });

    // Fallback bila data jabatan custom tanpa kata kunci standar
    if ($tierPuncak->isEmpty() && $allPersons->isNotEmpty()) {
        $tierPuncak = collect([$allPersons->first()]);
        $tierAnggota = $tierAnggota->reject(fn($p) => $p === $allPersons->first());
    }

    $warnaPrimer = $banom->warna_primer ?? '#004125';
@endphp

@if ($allPersons->isEmpty())
    <div class="p-8 sm:p-12 text-center bg-white rounded-3xl border border-[#e6eeff] text-xs text-gray-500 shadow-sm space-y-2">
        <span class="material-symbols-outlined text-4xl text-gray-300">badge</span>
        <p class="font-semibold">Belum ada data pengurus aktif yang tercatat untuk {{ $banom->singkatan }}.</p>
    </div>
@else
    <div class="py-4 space-y-8">
        
        <!-- ================= LEVEL 1: PUNCAK PIRAMIDA (KETUA / PIMPINAN TERTINGGI) ================= -->
        @if ($tierPuncak->isNotEmpty())
            <div class="space-y-4">
                <div class="flex items-center justify-center gap-2">
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider text-white shadow-xs" style="background-color: {{ $warnaPrimer }};">
                        Puncak Hierarki • Pimpinan Tertinggi
                    </span>
                </div>

                <div class="flex flex-wrap justify-center gap-6">
                    @foreach ($tierPuncak as $person)
                        <div class="w-full max-w-sm sm:max-w-md bg-white rounded-3xl p-6 sm:p-7 border-2 shadow-xl hover:shadow-2xl transition-all duration-300 text-center relative overflow-hidden group" style="border-color: {{ $warnaPrimer }};">
                            <!-- Background Accent Glow -->
                            <div class="absolute -top-12 left-1/2 -translate-x-1/2 w-40 h-40 rounded-full blur-2xl opacity-15 pointer-events-none" style="background-color: {{ $warnaPrimer }};"></div>

                            <div class="relative space-y-4">
                                <div class="relative inline-block">
                                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl mx-auto overflow-hidden shadow-md border-2 border-white flex items-center justify-center bg-gray-50">
                                        @if ($person->foto)
                                            <img src="{{ $person->foto }}" alt="{{ $person->nama }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-white text-2xl font-black" style="background-color: {{ $warnaPrimer }};">
                                                {{ strtoupper(substr($person->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 px-2.5 py-0.5 rounded-full text-[9px] font-extrabold text-white uppercase shadow-xs whitespace-nowrap" style="background-color: {{ $warnaPrimer }};">
                                        {{ $person->jabatan }}
                                    </span>
                                </div>

                                <div class="pt-1 space-y-1">
                                    <h3 class="text-base sm:text-lg font-black text-gray-900 group-hover:text-emerald-800 transition">
                                        {{ $person->nama }}
                                    </h3>
                                    <p class="text-xs font-bold text-gray-500">
                                        Pimpinan Ranting {{ $banom->singkatan }}
                                    </p>
                                    @if ($person->nia)
                                        <p class="text-[10px] font-mono text-emerald-800 bg-emerald-50 px-2 py-0.5 rounded-md inline-block">
                                            NIA: {{ $person->nia }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Connector Stem Downwards -->
                @if ($tierWakil->isNotEmpty() || $tierSekretariatBendahara->isNotEmpty() || $tierBidang->isNotEmpty() || $tierAnggota->isNotEmpty())
                    <div class="flex justify-center">
                        <div class="w-0.5 h-6 bg-gradient-to-b from-gray-300 to-gray-200"></div>
                    </div>
                @endif
            </div>
        @endif

        <!-- ================= LEVEL 2: WAKIL PIMPINAN (MELEBAR KE SAMPING) ================= -->
        @if ($tierWakil->isNotEmpty())
            <div class="space-y-4">
                <div class="flex items-center justify-center gap-2">
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-700">
                        Level II • Wakil Pimpinan
                    </span>
                </div>

                <div class="flex flex-wrap justify-center gap-4 max-w-2xl mx-auto">
                    @foreach ($tierWakil as $person)
                        <div class="w-full sm:w-[calc(50%-0.5rem)] bg-white rounded-2xl p-4 sm:p-5 border border-gray-200 shadow-sm hover:shadow-md transition text-center space-y-3">
                            <div class="w-14 h-14 rounded-xl mx-auto overflow-hidden shadow-xs border border-gray-100 flex items-center justify-center bg-gray-50">
                                @if ($person->foto)
                                    <img src="{{ $person->foto }}" alt="{{ $person->nama }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-white text-base font-black" style="background-color: {{ $warnaPrimer }};">
                                        {{ strtoupper(substr($person->nama, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="space-y-0.5">
                                <span class="text-[10px] font-extrabold uppercase px-2 py-0.5 rounded bg-emerald-50 text-emerald-800 inline-block">
                                    {{ $person->jabatan }}
                                </span>
                                <h4 class="text-xs sm:text-sm font-bold text-gray-900 truncate" title="{{ $person->nama }}">
                                    {{ $person->nama }}
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Connector Stem Downwards -->
                @if ($tierSekretariatBendahara->isNotEmpty() || $tierBidang->isNotEmpty() || $tierAnggota->isNotEmpty())
                    <div class="flex justify-center">
                        <div class="w-0.5 h-6 bg-gradient-to-b from-gray-300 to-gray-200"></div>
                    </div>
                @endif
            </div>
        @endif

        <!-- ================= LEVEL 3: SEKRETARIAT & KEBENDAHARAAN (LEBIH MELEBAR) ================= -->
        @if ($tierSekretariatBendahara->isNotEmpty())
            <div class="space-y-4">
                <div class="flex items-center justify-center gap-2">
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-700">
                        Level III • Sekretariat & Kebendaharaan
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 max-w-4xl mx-auto">
                    @foreach ($tierSekretariatBendahara as $person)
                        <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-sm hover:shadow-md transition flex items-center sm:flex-col sm:text-center gap-3">
                            <div class="w-12 h-12 rounded-xl shrink-0 overflow-hidden shadow-xs border border-gray-100 flex items-center justify-center bg-gray-50">
                                @if ($person->foto)
                                    <img src="{{ $person->foto }}" alt="{{ $person->nama }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-white text-sm font-black" style="background-color: {{ $warnaPrimer }};">
                                        {{ strtoupper(substr($person->nama, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1 space-y-0.5">
                                <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded bg-blue-50 text-blue-800 inline-block">
                                    {{ $person->jabatan }}
                                </span>
                                <h4 class="text-xs font-bold text-gray-900 truncate" title="{{ $person->nama }}">
                                    {{ $person->nama }}
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Connector Stem Downwards -->
                @if ($tierBidang->isNotEmpty() || $tierAnggota->isNotEmpty())
                    <div class="flex justify-center">
                        <div class="w-0.5 h-6 bg-gradient-to-b from-gray-300 to-gray-200"></div>
                    </div>
                @endif
            </div>
        @endif

        <!-- ================= LEVEL 4: BIDANG / DEPARTEMEN / DIVISI KERJA ================= -->
        @if ($tierBidang->isNotEmpty())
            <div class="space-y-4">
                <div class="flex items-center justify-center gap-2">
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-700">
                        Level IV • Bidang, Departemen & Divisi
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 max-w-5xl mx-auto">
                    @foreach ($tierBidang as $person)
                        <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-sm hover:shadow-md transition flex items-center gap-3">
                            <div class="w-11 h-11 rounded-xl shrink-0 overflow-hidden shadow-xs border border-gray-100 flex items-center justify-center bg-gray-50">
                                @if ($person->foto)
                                    <img src="{{ $person->foto }}" alt="{{ $person->nama }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-white text-xs font-black" style="background-color: {{ $warnaPrimer }};">
                                        {{ strtoupper(substr($person->nama, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1 space-y-0.5">
                                <span class="text-[9px] font-bold uppercase px-2 py-0.5 rounded bg-amber-50 text-amber-800 inline-block">
                                    {{ $person->jabatan }}
                                </span>
                                <h4 class="text-xs font-bold text-gray-900 truncate" title="{{ $person->nama }}">
                                    {{ $person->nama }}
                                </h4>
                                @if ($person->sub_jabatan)
                                    <p class="text-[10px] text-gray-500 truncate">{{ $person->sub_jabatan }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Connector Stem Downwards -->
                @if ($tierAnggota->isNotEmpty())
                    <div class="flex justify-center">
                        <div class="w-0.5 h-6 bg-gradient-to-b from-gray-300 to-gray-200"></div>
                    </div>
                @endif
            </div>
        @endif

        <!-- ================= LEVEL 5: ANGGOTA / KADER PELAKSANA ================= -->
        @if ($tierAnggota->isNotEmpty())
            <div class="space-y-4">
                <div class="flex items-center justify-center gap-2">
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-gray-100 text-gray-700">
                        Level V • Anggota & Kader Pengurus
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 max-w-6xl mx-auto">
                    @foreach ($tierAnggota as $person)
                        <div class="bg-white rounded-xl p-3 border border-gray-200 shadow-2xs hover:shadow-sm transition flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg shrink-0 overflow-hidden border border-gray-100 flex items-center justify-center bg-gray-50">
                                @if ($person->foto)
                                    <img src="{{ $person->foto }}" alt="{{ $person->nama }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-white text-[11px] font-black" style="background-color: {{ $warnaPrimer }};">
                                        {{ strtoupper(substr($person->nama, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <h5 class="text-xs font-semibold text-gray-900 truncate" title="{{ $person->nama }}">{{ $person->nama }}</h5>
                                <span class="text-[10px] text-gray-500 block truncate">{{ $person->jabatan }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endif
