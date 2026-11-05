@extends('layouts.app')

@section('title', 'Pasien Rawat Jalan - Front Office SIMHUIM')

@section('content')
<div x-data="{
    openTambah: false,
    openBayar: false,
    selectedPRJ: {},
    departemenTarif: {
        @foreach($tarifs as $t)
            '{{ $t->departemen }}': {{ $t->tarif }},
        @endforeach
    },
    selectedDept: 'Umum',
    currentTarif: 150000,
    updateTarif() {
        this.currentTarif = this.departemenTarif[this.selectedDept] || 0;
    }
}" x-init="updateTarif()">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Pasien Rawat Jalan (Poliklinik)</h1>
            <p class="text-sm text-slate-500 mt-1">Registrasi kunjungan poliklinik, antrean departemen, dan administrasi pembayaran tindakan.</p>
        </div>
        <div>
            <button @click="openTambah = true"
                    class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-teal-600 hover:bg-teal-700 shadow-sm transition-all">
                <i class="fa-solid fa-plus-circle mr-2"></i> Pendaftaran Rawat Jalan
            </button>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <!-- Search Bar -->
        <div class="p-4 sm:p-6 border-b border-slate-200/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <form method="GET" action="{{ route('front-office.prj.index') }}" class="relative max-w-sm w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input type="text" name="search" value="{{ $search }}"
                       placeholder="Cari pasien, No. RM, poli..."
                       class="block w-full pl-9 pr-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition">
            </form>
            <div class="text-xs text-slate-500 font-medium">
                Total: {{ $rawatJalans->total() }} pendaftaran kunjungan
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/80 text-xs uppercase font-bold text-slate-500 border-b border-slate-200 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">No. RJ / Tgl</th>
                        <th class="py-3.5 px-4">Pasien</th>
                        <th class="py-3.5 px-4">Departemen / Poli</th>
                        <th class="py-3.5 px-4">Dokter Pemeriksa</th>
                        <th class="py-3.5 px-4">Keluhan & Diagnosa</th>
                        <th class="py-3.5 px-4">Biaya / Bayar</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center w-28">Aksi</th>
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
                                <div class="font-bold text-slate-900">{{ $prj->pasien->nama_pasien ?? 'Pasien Tidak Diketahui' }}</div>
                                <div class="text-xs text-slate-400 font-mono">{{ $prj->pasien->no_rekam_medis ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-teal-50 text-teal-800 border border-teal-200">
                                    {{ $prj->departemen }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-xs">
                                @if($prj->dokter)
                                    <div class="font-semibold text-slate-900">{{ $prj->dokter->nama_dokter }}</div>
                                @else
                                    <span class="inline-flex items-center text-amber-700 bg-amber-50 px-2 py-0.5 rounded text-[11px] font-medium border border-amber-200">
                                        <i class="fa-solid fa-clock-rotate-left mr-1 text-[10px]"></i> Menunggu Penugasan Poli
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-xs max-w-xs">
                                <div class="text-slate-800 font-medium truncate" title="{{ $prj->keluhan }}">
                                    <span class="text-slate-400">Keluhan:</span> {{ $prj->keluhan }}
                                </div>
                                @if($prj->diagnosa)
                                    <div class="text-emerald-700 font-medium truncate mt-0.5" title="{{ $prj->diagnosa }}">
                                        <span class="text-slate-400">Diagnosa:</span> {{ $prj->diagnosa }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-xs font-mono">
                                <div class="text-slate-900 font-bold">Rp {{ number_format($prj->biaya, 0, ',', '.') }}</div>
                                <div class="text-slate-500 text-[11px]">Bayar: Rp {{ number_format($prj->bayar, 0, ',', '.') }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($prj->isLunas())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-emerald-100 text-emerald-800">
                                        LUNAS
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-rose-100 text-rose-800">
                                        BELUM
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <button @click="selectedPRJ = {{ json_encode($prj) }}; openBayar = true"
                                            class="w-7 h-7 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 flex items-center justify-center transition"
                                            title="Kelola Pembayaran & Tindakan">
                                        <i class="fa-solid fa-money-bill-wave text-xs"></i>
                                    </button>
                                    <form action="{{ route('front-office.prj.destroy', $prj->id) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kunjungan rawat jalan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 flex items-center justify-center transition"
                                                title="Hapus Data">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-inbox text-3xl mb-2 block"></i>
                                Belum ada kunjungan rawat jalan.
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

    <!-- MODAL PENDAFTARAN RAWAT JALAN -->
    <div x-show="openTambah" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="openTambah = false"></div>

            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl max-w-lg w-full border border-slate-100">
                <form action="{{ route('front-office.prj.store') }}" method="POST">
                    @csrf
                    <div class="bg-teal-700 px-6 py-4 flex items-center justify-between text-white">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-stethoscope text-lg"></i>
                            <h3 class="text-base font-bold">Pendaftaran Pasien Rawat Jalan (PRJ)</h3>
                        </div>
                        <button type="button" @click="openTambah = false" class="text-teal-200 hover:text-white">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Pasien Terdaftar *</label>
                            <select name="pasien_id" required class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500">
                                <option value="">-- Pilih Pasien --</option>
                                @foreach($pasiens as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_pasien }} ({{ $p->no_rekam_medis ?? ('RM-' . $p->id) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Poliklinik / Departemen Tujuan *</label>
                            <select name="departemen" x-model="selectedDept" @change="updateTarif()" required class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500">
                                @foreach($tarifs as $t)
                                    <option value="{{ $t->departemen }}">{{ $t->departemen }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="bg-teal-50 border border-teal-200 rounded-xl p-3 flex items-center justify-between">
                            <span class="text-xs font-semibold text-teal-900">Tarif Registrasi & Tindakan Dasar:</span>
                            <span class="text-sm font-extrabold font-mono text-teal-700">Rp <span x-text="new Intl.NumberFormat('id-ID').format(currentTarif)"></span></span>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Dokter Pemeriksa (Opsional)</label>
                            <select name="dokter_id" class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500">
                                <option value="">-- Tugaskan Nanti oleh Poli --</option>
                                @foreach($dokters as $d)
                                    <option value="{{ $d->id }}">{{ $d->nama_dokter }} (Poli {{ $d->departemen }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Keluhan Pasien *</label>
                            <textarea name="keluhan" rows="3" required placeholder="Jelaskan keluhan utama pasien..."
                                      class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah Pembayaran Awal (Rp)</label>
                            <input type="number" name="bayar" min="0" placeholder="0"
                                   class="w-full text-sm font-mono border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end space-x-3">
                        <button type="button" @click="openTambah = false" class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-100">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-teal-600 hover:bg-teal-700 rounded-xl shadow">
                            <i class="fa-solid fa-check mr-1.5"></i> Daftarkan Rawat Jalan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL PEMBAYARAN RAWAT JALAN -->
    <div x-show="openBayar" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="openBayar = false"></div>

            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl max-w-md w-full border border-slate-100">
                <form :action="'/front-office/rawat-jalan/' + selectedPRJ.id" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-emerald-700 px-6 py-4 flex items-center justify-between text-white">
                        <h3 class="text-base font-bold">Kasir & Pembayaran Rawat Jalan</h3>
                        <button type="button" @click="openBayar = false" class="text-emerald-200 hover:text-white">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 text-xs">
                            <div class="flex justify-between py-1">
                                <span class="text-slate-500">Pasien:</span>
                                <span class="font-bold text-slate-800" x-text="selectedPRJ.pasien?.nama_pasien"></span>
                            </div>
                            <div class="flex justify-between py-1">
                                <span class="text-slate-500">Total Biaya:</span>
                                <span class="font-bold font-mono text-slate-900">Rp <span x-text="new Intl.NumberFormat('id-ID').format(selectedPRJ.biaya || 0)"></span></span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Keluhan</label>
                            <input type="text" name="keluhan" x-model="selectedPRJ.keluhan" required
                                   class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Tindakan</label>
                            <input type="text" name="tindakan" x-model="selectedPRJ.tindakan" placeholder="Catatan tindakan medis..."
                                   class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Total Dibayar (Rp) *</label>
                            <input type="number" name="bayar" x-model="selectedPRJ.bayar" required min="0"
                                   class="w-full text-sm font-mono border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-emerald-500">
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end space-x-3">
                        <button type="button" @click="openBayar = false" class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow">
                            Simpan Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
