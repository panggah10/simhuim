@extends('layouts.app')

@section('title', 'Meja Konsultasi Dokter - SIMHUIM')

@section('content')
<div x-data="{
    openDiagnosa: false,
    selectedPRJ: {},
}">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="inline-flex items-center space-x-2 text-xs font-bold text-sky-800 bg-sky-100/80 px-2.5 py-1 rounded-full mb-1">
                <i class="fa-solid fa-user-doctor"></i>
                <span>RUANG PRAKTIK POLI {{ strtoupper($dokter->departemen) }}</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Meja Pemeriksaan Dokter</h1>
            <p class="text-sm text-slate-500 mt-0.5">Dokter: <strong class="text-slate-800 font-semibold">{{ $dokter->nama_dokter }}</strong> | Jadwal: {{ $dokter->jadwal_praktik }}</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('dokter.resep.index') }}"
               class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-white bg-teal-600 hover:bg-teal-700 shadow-sm transition">
                <i class="fa-solid fa-prescription mr-2"></i> Kelola E-Resep ({{ $totalResepDokter }})
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pasien Masuk Konsultasi</span>
                <div class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalPasienDokter }}</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-clipboard-user"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Resep Obat Terbit</span>
                <div class="text-2xl font-extrabold text-teal-600 mt-1">{{ $totalResepDokter }}</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-prescription"></i>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <!-- Search Bar -->
        <div class="p-4 sm:p-6 border-b border-slate-200/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <form method="GET" action="{{ route('dokter.pasien.index') }}" class="relative max-w-sm w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input type="text" name="search" value="{{ $search }}"
                       placeholder="Cari pasien, No. RM, atau keluhan..."
                       class="block w-full pl-9 pr-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition">
            </form>
            <div class="text-xs text-slate-500 font-medium">
                Daftar pasien yang ditugaskan kepada Anda
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/80 text-xs uppercase font-bold text-slate-500 border-b border-slate-200 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">No. RJ / Tgl</th>
                        <th class="py-3.5 px-4">Identitas Pasien</th>
                        <th class="py-3.5 px-4">Keluhan Utama</th>
                        <th class="py-3.5 px-4">Hasil Diagnosa</th>
                        <th class="py-3.5 px-4">Tindakan Medis</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
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
                                <div class="text-xs text-slate-400 font-mono">{{ $prj->pasien->no_rekam_medis ?? '-' }} ({{ $prj->pasien->jenis_kelamin ?? '-' }})</div>
                            </td>
                            <td class="py-3.5 px-4 text-xs max-w-xs">
                                <p class="text-slate-800 font-medium" title="{{ $prj->keluhan }}">
                                    {{ $prj->keluhan }}
                                </p>
                            </td>
                            <td class="py-3.5 px-4 text-xs max-w-xs">
                                @if($prj->diagnosa)
                                    <div class="text-emerald-800 font-semibold bg-emerald-50 px-2 py-1 rounded border border-emerald-200">
                                        {{ $prj->diagnosa }}
                                    </div>
                                @else
                                    <span class="text-slate-400 italic">Belum diinput</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-xs">
                                {{ $prj->tindakan ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($prj->diagnosa)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-emerald-100 text-emerald-800">
                                        SELESAI
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-amber-100 text-amber-800">
                                        ANTRE
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <button @click="selectedPRJ = {{ json_encode($prj) }}; openDiagnosa = true"
                                        class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold text-white bg-sky-600 hover:bg-sky-700 transition shadow-sm">
                                    <i class="fa-solid fa-stethoscope mr-1.5"></i>
                                    <span>{{ $prj->diagnosa ? 'Edit Diagnosa' : 'Tulis Diagnosa' }}</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-clipboard-user text-3xl mb-2 block"></i>
                                Belum ada pasien yang ditugaskan kepada Anda saat ini.
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

    <!-- MODAL DIAGNOSA & TINDAKAN DOKTER -->
    <div x-show="openDiagnosa" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="openDiagnosa = false"></div>

            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl max-w-lg w-full border border-slate-100">
                <form :action="'/dokter/pasien/' + selectedPRJ.id + '/diagnosa'" method="POST">
                    @csrf
                    <div class="bg-sky-700 px-6 py-4 flex items-center justify-between text-white">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-stethoscope text-lg"></i>
                            <h3 class="text-base font-bold">Hasil Pemeriksaan Klinis & Diagnosa</h3>
                        </div>
                        <button type="button" @click="openDiagnosa = false" class="text-sky-200 hover:text-white">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 text-xs">
                            <div class="flex justify-between py-1">
                                <span class="text-slate-500">Pasien:</span>
                                <span class="font-bold text-slate-900" x-text="selectedPRJ.pasien?.nama_pasien"></span>
                            </div>
                            <div class="flex justify-between py-1">
                                <span class="text-slate-500">Keluhan:</span>
                                <span class="text-slate-800 font-medium italic" x-text="selectedPRJ.keluhan"></span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Diagnosa Klinis *</label>
                            <textarea name="diagnosa" x-model="selectedPRJ.diagnosa" rows="3" required
                                      placeholder="Tuliskan hasil diagnosa penyakit/kondisi medis pasien..."
                                      class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-sky-500"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Tindakan Medis yang Diberikan</label>
                            <input type="text" name="tindakan" x-model="selectedPRJ.tindakan"
                                   placeholder="Contoh: Pemberian obat oral, nebulizer, perban..."
                                   class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-sky-500">
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end space-x-3">
                        <button type="button" @click="openDiagnosa = false" class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-sky-600 hover:bg-sky-700 rounded-xl shadow">
                            <i class="fa-solid fa-save mr-1.5"></i> Simpan Diagnosa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
