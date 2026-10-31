@extends('layouts.app')

@section('title', 'Master Tarif Pelayanan - Front Office SIMHUIM')

@section('content')
<div x-data="{ tab: 'rj' }">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Daftar Master Tarif Rumah Sakit</h1>
        <p class="text-sm text-slate-500 mt-1">Standar biaya pelayanan medis, tindakan poliklinik, dan akomodasi rawat inap Mini Hospital UIM.</p>
    </div>

    <!-- Tab Buttons -->
    <div class="flex space-x-2 border-b border-slate-200 mb-6">
        <button @click="tab = 'rj'"
                :class="tab === 'rj' ? 'border-teal-600 text-teal-700 font-bold' : 'border-transparent text-slate-500 hover:text-slate-700'"
                class="py-3 px-4 text-sm border-b-2 font-medium transition flex items-center space-x-2">
            <i class="fa-solid fa-stethoscope"></i>
            <span>Tarif Poliklinik & Rawat Jalan ({{ $tarifRJ->count() }})</span>
        </button>
        <button @click="tab = 'ri'"
                :class="tab === 'ri' ? 'border-teal-600 text-teal-700 font-bold' : 'border-transparent text-slate-500 hover:text-slate-700'"
                class="py-3 px-4 text-sm border-b-2 font-medium transition flex items-center space-x-2">
            <i class="fa-solid fa-bed-pulse"></i>
            <span>Tarif Kamar & Rawat Inap ({{ $tarifRI->count() }})</span>
        </button>
    </div>

    <!-- Tab 1: Rawat Jalan -->
    <div x-show="tab === 'rj'" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-900 text-sm">Tarif Tindakan Medis & Poliklinik Rawat Jalan</h3>
            <span class="text-xs text-slate-400">Diperbarui berdasarkan SK Tarif UIM</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4 w-12 text-center">No</th>
                        <th class="py-3 px-4">Poliklinik / Departemen</th>
                        <th class="py-3 px-4 text-right">Tarif Dasar Pemeriksaan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($tarifRJ as $index => $t)
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-3 px-4 text-center text-slate-400 font-medium">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-900">
                                <i class="fa-regular fa-hospital text-teal-600 mr-2"></i> Poli {{ $t->departemen }}
                            </td>
                            <td class="py-3 px-4 text-right font-mono font-bold text-teal-700">
                                Rp {{ number_format($t->tarif, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab 2: Rawat Inap -->
    <div x-show="tab === 'ri'" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden" x-cloak>
        <div class="p-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-900 text-sm">Tarif Kamar & Fasilitas Perawatan Rawat Inap</h3>
            <span class="text-xs text-slate-400">Satuan Biaya per Hari Rawat</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4 w-12 text-center">No</th>
                        <th class="py-3 px-4">Instalasi / Perawatan</th>
                        <th class="py-3 px-4">Pelayanan</th>
                        <th class="py-3 px-4">Tipe / Kelas Kamar</th>
                        <th class="py-3 px-4 text-center">Kapasitas</th>
                        <th class="py-3 px-4 text-right">Tarif per Hari</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($tarifRI as $index => $t)
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-3 px-4 text-center text-slate-400 font-medium">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-900">{{ $t->perawatan }}</td>
                            <td class="py-3 px-4 text-xs text-slate-600">{{ $t->pelayanan }}</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-slate-100 text-slate-800 border border-slate-200">
                                    {{ $t->tipe_kamar ?: 'Standar' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center font-mono text-xs">{{ $t->kapasitas }} Bed</td>
                            <td class="py-3 px-4 text-right font-mono font-bold text-teal-700">
                                Rp {{ number_format($t->tarif, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
