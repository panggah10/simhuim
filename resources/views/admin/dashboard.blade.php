@extends('layouts.app')

@section('title', 'Admin Dashboard - SIMHUIM')

@section('content')
<div>
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="inline-flex items-center space-x-2 text-xs font-bold text-purple-800 bg-purple-100/80 px-2.5 py-1 rounded-full mb-1">
                <i class="fa-solid fa-shield-halved"></i>
                <span>PORTAL ADMINISTRATOR UTAMA</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Dashboard & Analitik Rumah Sakit</h1>
            <p class="text-sm text-slate-500 mt-0.5">Pemantauan menyeluruh operasional Mini Hospital UIM Yogyakarta secara real-time.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-bold text-purple-700 bg-purple-50 hover:bg-purple-100 border border-purple-200 transition">
                <i class="fa-solid fa-users-gear mr-1.5"></i> Kelola Pengguna
            </a>
            <a href="{{ route('front-office.pasien.index') }}"
               class="inline-flex items-center px-3.5 py-2 rounded-xl text-xs font-bold text-teal-700 bg-teal-50 hover:bg-teal-100 border border-teal-200 transition">
                <i class="fa-solid fa-hospital mr-1.5"></i> Buka Front Office
            </a>
        </div>
    </div>

    <!-- Main Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Pendapatan Total -->
        <div class="bg-gradient-to-br from-teal-700 to-emerald-800 p-5 rounded-2xl text-white shadow-md flex items-center justify-between">
            <div>
                <span class="text-xs uppercase font-semibold text-teal-200/90 tracking-wider">Total Pendapatan RS</span>
                <div class="text-2xl font-extrabold tracking-tight mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                <div class="text-[11px] text-teal-100/80 mt-1">PRJ: Rp {{ number_format($pendapatanPRJ, 0, ',', '.') }} | PRI: Rp {{ number_format($pendapatanPRI, 0, ',', '.') }}</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-2xl text-emerald-200 border border-white/20">
                <i class="fa-solid fa-sack-dollar"></i>
            </div>
        </div>

        <!-- Total Pasien -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pasien Terdaftar</span>
                <div class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalPasien }}</div>
                <span class="text-[11px] text-emerald-600 font-medium"><i class="fa-solid fa-circle-check"></i> Rekam Medis Aktif</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-2xl">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

        <!-- Rawat Jalan vs Inap -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Rawat Jalan / Inap</span>
                <div class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalPRJ }} / <span class="text-amber-600">{{ $totalPRI }}</span></div>
                <span class="text-[11px] text-slate-500 font-medium">Kunjungan Poliklinik & Opname</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-2xl">
                <i class="fa-solid fa-bed-pulse"></i>
            </div>
        </div>

        <!-- Dokter & User -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Tenaga Medis & Akun</span>
                <div class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalDokter }} <span class="text-sm font-semibold text-slate-400">dr</span> / {{ $totalUser }} <span class="text-sm font-semibold text-slate-400">user</span></div>
                <span class="text-[11px] text-purple-600 font-medium"><i class="fa-solid fa-shield"></i> {{ $totalResep }} E-Resep Terbit</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl">
                <i class="fa-solid fa-user-doctor"></i>
            </div>
        </div>
    </div>

    <!-- 2 Column Section: Poli Performance & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Statistik Per Poliklinik -->
        <div class="lg:col-span-1 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 flex items-center justify-between">
                <span>Kunjungan Poliklinik</span>
                <i class="fa-solid fa-chart-pie text-slate-400"></i>
            </h3>

            <div class="space-y-3">
                @forelse($poliStats as $p)
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-between">
                        <div>
                            <div class="font-bold text-xs text-slate-900">Poli {{ $p->departemen }}</div>
                            <div class="text-[11px] text-slate-500 font-mono">Rp {{ number_format($p->pendapatan, 0, ',', '.') }}</div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-teal-100 text-teal-800">
                            {{ $p->total }} Pasien
                        </span>
                    </div>
                @empty
                    <div class="text-center text-slate-400 py-6 text-xs">Belum ada transaksi kunjungan.</div>
                @endforelse
            </div>
        </div>

        <!-- Aktivitas Pasien Terbaru -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">
                    Kunjungan Pasien Rawat Jalan Terbaru
                </h3>
                <a href="{{ route('front-office.prj.index') }}" class="text-xs text-teal-700 hover:text-teal-900 font-semibold">
                    Lihat Semua <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase border-b border-slate-200">
                        <tr>
                            <th class="py-2.5 px-3">Pasien</th>
                            <th class="py-2.5 px-3">Poli</th>
                            <th class="py-2.5 px-3">Dokter</th>
                            <th class="py-2.5 px-3 text-right">Biaya / Bayar</th>
                            <th class="py-2.5 px-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentPRJ as $rj)
                            <tr class="hover:bg-slate-50/50">
                                <td class="py-2.5 px-3">
                                    <div class="font-bold text-slate-900">{{ $rj->pasien->nama_pasien ?? 'Pasien' }}</div>
                                    <span class="text-[11px] text-slate-400 font-mono">{{ $rj->pasien->no_rekam_medis ?? '-' }}</span>
                                </td>
                                <td class="py-2.5 px-3 font-semibold text-teal-700">Poli {{ $rj->departemen }}</td>
                                <td class="py-2.5 px-3 text-slate-700">{{ $rj->dokter->nama_dokter ?? 'Menunggu Penugasan' }}</td>
                                <td class="py-2.5 px-3 text-right font-mono">
                                    <div class="font-bold text-slate-800">Rp {{ number_format($rj->biaya, 0, ',', '.') }}</div>
                                    <div class="text-[10px] text-slate-400">Bayar: Rp {{ number_format($rj->bayar, 0, ',', '.') }}</div>
                                </td>
                                <td class="py-2.5 px-3 text-center">
                                    @if($rj->isLunas())
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">LUNAS</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-800">BELUM</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-slate-400">Belum ada catatan kunjungan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
