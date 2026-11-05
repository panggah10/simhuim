@extends('layouts.app')

@section('title', 'Jadwal Dokter - Poli ' . $departemenNama . ' SIMHUIM')

@section('content')
<div>
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="inline-flex items-center space-x-2 text-xs font-bold text-teal-800 bg-teal-100/80 px-2.5 py-1 rounded-full mb-1">
                <i class="fa-solid fa-hospital"></i>
                <span>POLIKLINIK {{ strtoupper($departemenNama) }}</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Daftar Dokter & Jadwal Praktik</h1>
            <p class="text-sm text-slate-500 mt-0.5">Informasi tenaga medis spesialis dan ketersediaan waktu konsultasi di poli ini.</p>
        </div>
        <div>
            <a href="{{ route('departemen.pasien.index') }}"
               class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 shadow-sm transition">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Antrean Poli
            </a>
        </div>
    </div>

    <!-- Doctor Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($dokters as $d)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden hover:shadow-md transition">
                <div class="p-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center text-2xl flex-shrink-0 border border-teal-100">
                            <i class="fa-solid fa-user-doctor"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-base font-bold text-slate-900 leading-snug truncate" title="{{ $d->nama_dokter }}">
                                {{ $d->nama_dokter }}
                            </h3>
                            <p class="text-xs font-semibold text-teal-700 mt-0.5">
                                Spesialis {{ $d->departemen }}
                            </p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200 mt-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Aktif Bertugas
                            </span>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-100 text-xs text-slate-600 space-y-2">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-calendar-days text-slate-400 w-4"></i>
                            <span class="font-medium text-slate-800">{{ $d->jadwal_praktik }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-location-dot text-slate-400 w-4"></i>
                            <span>Ruang Konsultasi Poli {{ $d->departemen }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white p-12 text-center rounded-2xl border border-slate-200 text-slate-400">
                <i class="fa-solid fa-user-doctor text-4xl mb-3 block"></i>
                Belum ada dokter yang terdaftar di Poli {{ $departemenNama }}.
            </div>
        @endforelse
    </div>
</div>
@endsection
