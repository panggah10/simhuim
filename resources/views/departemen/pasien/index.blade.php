@extends('layouts.app')

@section('title', 'Antrean Pasien - Poli ' . $departemenNama . ' SIMHUIM')

@section('content')
<div x-data="{
    openAssign: false,
    selectedPRJ: {},
}">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="inline-flex items-center space-x-2 text-xs font-bold text-teal-800 bg-teal-100/80 px-2.5 py-1 rounded-full mb-1">
                <i class="fa-solid fa-hospital"></i>
                <span>POLIKLINIK {{ strtoupper($departemenNama) }}</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Antrean Pasien Rawat Jalan</h1>
            <p class="text-sm text-slate-500 mt-0.5">Kelola antrean kunjungan dan delegasikan pasien ke dokter pemeriksa yang bertugas.</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('departemen.dokter.jadwal') }}"
               class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 border border-teal-200 transition">
                <i class="fa-solid fa-calendar-check mr-2"></i> Jadwal Dokter ({{ $totalDokterDept }})
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pasien Poli</span>
                <div class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalPasienDept }}</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dokter Bertugas</span>
                <div class="text-2xl font-extrabold text-sky-600 mt-1">{{ $totalDokterDept }}</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-user-doctor"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Unit / Departemen</span>
                <div class="text-lg font-bold text-slate-800 mt-1">Poli {{ $departemenNama }}</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-clinic-medical"></i>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <!-- Search Bar -->
        <div class="p-4 sm:p-6 border-b border-slate-200/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <form method="GET" action="{{ route('departemen.pasien.index') }}" class="relative max-w-sm w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input type="text" name="search" value="{{ $search }}"
                       placeholder="Cari pasien atau keluhan..."
                       class="block w-full pl-9 pr-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition">
            </form>
            <div class="text-xs text-slate-500 font-medium">
                Menampilkan antrean Poli {{ $departemenNama }}
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/80 text-xs uppercase font-bold text-slate-500 border-b border-slate-200 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">No. RJ / Jam</th>
                        <th class="py-3.5 px-4">Pasien</th>
                        <th class="py-3.5 px-4">Keluhan</th>
                        <th class="py-3.5 px-4">Dokter Ditugaskan</th>
                        <th class="py-3.5 px-4 text-center">Status Periksa</th>
                        <th class="py-3.5 px-4 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rawatJalans as $index => $prj)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 text-center font-medium text-slate-400">
                                {{ $rawatJalans->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-xs">
                                <span class="font-bold text-slate-900 block">RJ-{{ str_pad($prj->id, 5, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-slate-400 text-[11px]">{{ $prj->tanggal->format('d/m/Y H:i') }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900">{{ $prj->pasien->nama_pasien ?? 'Pasien' }}</div>
                                <div class="text-xs text-slate-400 font-mono">{{ $prj->pasien->no_rekam_medis ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-xs max-w-xs">
                                <p class="text-slate-800 line-clamp-2" title="{{ $prj->keluhan }}">
                                    {{ $prj->keluhan }}
                                </p>
                            </td>
                            <td class="py-3.5 px-4 text-xs">
                                @if($prj->dokter)
                                    <div class="font-semibold text-slate-900 flex items-center space-x-1.5">
                                        <i class="fa-solid fa-user-doctor text-teal-600"></i>
                                        <span>{{ $prj->dokter->nama_dokter }}</span>
                                    </div>
                                    <span class="text-slate-400 text-[11px] block pl-5">{{ $prj->dokter->jadwal_praktik }}</span>
                                @else
                                    <span class="inline-flex items-center text-amber-700 bg-amber-50 px-2 py-0.5 rounded text-xs font-medium border border-amber-200">
                                        <i class="fa-solid fa-circle-exclamation mr-1"></i> Belum Dipilihkan
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($prj->diagnosa)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-emerald-100 text-emerald-800">
                                        <i class="fa-solid fa-circle-check mr-1 text-[10px]"></i> DIPERIKSA
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-rose-100 text-rose-800">
                                        <i class="fa-solid fa-clock mr-1 text-[10px]"></i> BELUM
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <button @click="selectedPRJ = {{ json_encode($prj) }}; openAssign = true"
                                        class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 border border-teal-200 transition shadow-sm">
                                    <i class="fa-solid fa-user-doctor mr-1.5"></i>
                                    <span>{{ $prj->dokter ? 'Ubah Dokter' : 'Pilih Dokter' }}</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-clipboard-check text-3xl mb-2 block"></i>
                                Belum ada antrean pasien untuk Poli {{ $departemenNama }}.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($rawatJalans->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $rawatJalans->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL PENUGASAN DOKTER -->
    <div x-show="openAssign" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="openAssign = false"></div>

            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl max-w-md w-full border border-slate-100">
                <form :action="'/departemen/pasien/' + selectedPRJ.id + '/assign-dokter'" method="POST">
                    @csrf
                    <div class="bg-teal-700 px-6 py-4 flex items-center justify-between text-white">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-user-doctor text-lg"></i>
                            <h3 class="text-base font-bold">Penugasan Dokter Pemeriksa</h3>
                        </div>
                        <button type="button" @click="openAssign = false" class="text-teal-200 hover:text-white">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="bg-teal-50 p-3.5 rounded-xl border border-teal-200 text-xs">
                            <div class="flex justify-between py-1">
                                <span class="text-slate-500">Nama Pasien:</span>
                                <span class="font-bold text-slate-900" x-text="selectedPRJ.pasien?.nama_pasien"></span>
                            </div>
                            <div class="flex justify-between py-1">
                                <span class="text-slate-500">Keluhan:</span>
                                <span class="text-slate-700 italic truncate max-w-xs" x-text="selectedPRJ.keluhan"></span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilih Dokter Poli {{ $departemenNama }} *</label>
                            <select name="dokter_id" required class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-teal-500">
                                <option value="">-- Pilih Dokter Spesialis --</option>
                                @foreach($dokters as $d)
                                    <option value="{{ $d->id }}">{{ $d->nama_dokter }} ({{ $d->jadwal_praktik }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end space-x-3">
                        <button type="button" @click="openAssign = false" class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-teal-600 hover:bg-teal-700 rounded-xl shadow">
                            <i class="fa-solid fa-check mr-1.5"></i> Tetapkan Dokter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
