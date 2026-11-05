@extends('layouts.app')

@section('title', 'Pasien Rawat Inap - Front Office SIMHUIM')

@section('content')
<div x-data="{
    openTambah: false,
    openEdit: false,
    selectedPRI: {},
    tarifsRI: {
        @foreach($tarifs as $t)
            '{{ $t->id }}': {
                'nama': '{{ $t->tipe_kamar }} - {{ $t->pelayanan }}',
                'tarif': {{ $t->tarif }}
            },
        @endforeach
    },
    selectedTarifId: '{{ $tarifs->first()->id ?? 1 }}',
    checkinDate: '{{ date('Y-m-d') }}',
    checkoutDate: '{{ date('Y-m-d') }}',
    get selectedRate() {
        return this.tarifsRI[this.selectedTarifId]?.tarif || 0;
    }
}">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Pasien Rawat Inap (PRI)</h1>
            <p class="text-sm text-slate-500 mt-1">Registrasi rawat inap kamar, pemantauan masa rawat, dan tagihan penyelesaian checkout.</p>
        </div>
        <div>
            <button @click="openTambah = true"
                    class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-teal-600 hover:bg-teal-700 shadow-sm transition-all">
                <i class="fa-solid fa-bed-pulse mr-2"></i> Pendaftaran Rawat Inap
            </button>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <!-- Search Bar -->
        <div class="p-4 sm:p-6 border-b border-slate-200/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <form method="GET" action="{{ route('front-office.pri.index') }}" class="relative max-w-sm w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input type="text" name="search" value="{{ $search }}"
                       placeholder="Cari pasien, kamar..."
                       class="block w-full pl-9 pr-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition">
            </form>
            <div class="text-xs text-slate-500 font-medium">
                Total: {{ $rawatInaps->total() }} catatan rawat inap
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/80 text-xs uppercase font-bold text-slate-500 border-b border-slate-200 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">No. RI</th>
                        <th class="py-3.5 px-4">Pasien</th>
                        <th class="py-3.5 px-4">Kamar / Ruang</th>
                        <th class="py-3.5 px-4">Check In / Out</th>
                        <th class="py-3.5 px-4">Hari Rawat</th>
                        <th class="py-3.5 px-4">Biaya Total</th>
                        <th class="py-3.5 px-4">Status Rawat</th>
                        <th class="py-3.5 px-4 text-center">Pembayaran</th>
                        <th class="py-3.5 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rawatInaps as $index => $pri)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 text-center font-medium text-slate-400">
                                {{ $rawatInaps->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-slate-900 text-xs">
                                RI-{{ str_pad($pri->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900">{{ $pri->pasien->nama_pasien ?? 'Pasien' }}</div>
                                <div class="text-xs text-slate-400 font-mono">{{ $pri->pasien->no_rekam_medis ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200 font-mono">
                                    {{ $pri->id_ruang }}
                                </span>
                                @if($pri->tarif)
                                    <div class="text-[11px] text-slate-500 mt-0.5">{{ $pri->tarif->tipe_kamar }} ({{ $pri->tarif->pelayanan }})</div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-xs">
                                <div class="text-slate-800 font-medium">In: {{ $pri->tanggal_checkin->format('d/m/Y') }}</div>
                                <div class="text-slate-500">Out: {{ $pri->tanggal_checkout ? $pri->tanggal_checkout->format('d/m/Y') : '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-mono font-semibold text-center text-xs">
                                {{ $pri->hari_menginap }} hari
                            </td>
                            <td class="py-3.5 px-4 text-xs font-mono">
                                <div class="text-slate-900 font-bold">Rp {{ number_format($pri->biaya, 0, ',', '.') }}</div>
                                <div class="text-slate-500 text-[11px]">Bayar: Rp {{ number_format($pri->bayar, 0, ',', '.') }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($pri->status === 'dirawat')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-amber-100 text-amber-800">
                                        <i class="fa-solid fa-bed mr-1 text-[10px]"></i> Dirawat
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-slate-100 text-slate-700">
                                        <i class="fa-solid fa-house-chimney mr-1 text-[10px]"></i> Pulang
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($pri->isLunas())
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
                                    <button @click="selectedPRI = {{ json_encode($pri) }}; openEdit = true"
                                            class="w-7 h-7 rounded-lg bg-teal-50 hover:bg-teal-100 text-teal-700 flex items-center justify-center transition"
                                            title="Checkout & Tagihan Kasir">
                                        <i class="fa-solid fa-file-invoice-dollar text-xs"></i>
                                    </button>
                                    <form action="{{ route('front-office.pri.destroy', $pri->id) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data rawat inap ini?')">
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
                            <td colspan="10" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-inbox text-3xl mb-2 block"></i>
                                Tidak ada data pasien rawat inap.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($rawatInaps->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $rawatInaps->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL PENDAFTARAN RAWAT INAP -->
    <div x-show="openTambah" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="openTambah = false"></div>

            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl max-w-lg w-full border border-slate-100">
                <form action="{{ route('front-office.pri.store') }}" method="POST">
                    @csrf
                    <div class="bg-teal-700 px-6 py-4 flex items-center justify-between text-white">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-bed-pulse text-lg"></i>
                            <h3 class="text-base font-bold">Pendaftaran Pasien Rawat Inap (PRI)</h3>
                        </div>
                        <button type="button" @click="openTambah = false" class="text-teal-200 hover:text-white">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Pasien *</label>
                            <select name="pasien_id" required class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500">
                                <option value="">-- Pilih Pasien --</option>
                                @foreach($pasiens as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_pasien }} ({{ $p->no_rekam_medis ?? ('RM-' . $p->id) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor / Kode Kamar/Ruang *</label>
                            <input type="text" name="id_ruang" required placeholder="Contoh: VIP-101 / Ruang Melati 2"
                                   class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Kelas & Tarif Rawat Inap *</label>
                            <select name="tarif_id" x-model="selectedTarifId" required class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500">
                                @foreach($tarifs as $t)
                                    <option value="{{ $t->id }}">
                                        {{ $t->tipe_kamar }} - {{ $t->pelayanan }} (Rp {{ number_format($t->tarif, 0, ',', '.') }}/hari)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="bg-teal-50 border border-teal-200 rounded-xl p-3 flex items-center justify-between">
                            <span class="text-xs font-semibold text-teal-900">Tarif Kamar per Hari:</span>
                            <span class="text-sm font-extrabold font-mono text-teal-700">Rp <span x-text="new Intl.NumberFormat('id-ID').format(selectedRate)"></span></span>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Check-In *</label>
                            <input type="date" name="tanggal_checkin" value="{{ date('Y-m-d') }}" required
                                   class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Diagnosa Masuk Rawat Inap</label>
                            <textarea name="diagnosa" rows="2" placeholder="Catatan diagnosa klinis awal..."
                                      class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Deposit / Uang Muka (Rp)</label>
                            <input type="number" name="bayar" min="0" placeholder="0"
                                   class="w-full text-sm font-mono border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end space-x-3">
                        <button type="button" @click="openTambah = false" class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-teal-600 hover:bg-teal-700 rounded-xl shadow">
                            <i class="fa-solid fa-check mr-1.5"></i> Daftarkan Rawat Inap
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL CHECKOUT & TAGIHAN KASIR RAWAT INAP -->
    <div x-show="openEdit" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="openEdit = false"></div>

            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl max-w-md w-full border border-slate-100">
                <form :action="'/front-office/rawat-inap/' + selectedPRI.id" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-amber-700 px-6 py-4 flex items-center justify-between text-white">
                        <h3 class="text-base font-bold">Checkout & Pelunasan Rawat Inap</h3>
                        <button type="button" @click="openEdit = false" class="text-amber-200 hover:text-white">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="bg-amber-50/80 p-3 rounded-xl border border-amber-200 text-xs">
                            <div class="flex justify-between py-1">
                                <span class="text-slate-600">Pasien:</span>
                                <span class="font-bold text-slate-900" x-text="selectedPRI.pasien?.nama_pasien"></span>
                            </div>
                            <div class="flex justify-between py-1">
                                <span class="text-slate-600">Kamar:</span>
                                <span class="font-bold font-mono text-slate-900" x-text="selectedPRI.id_ruang"></span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Kamar</label>
                            <input type="text" name="id_ruang" x-model="selectedPRI.id_ruang" required
                                   class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Tgl Check-In *</label>
                                <input type="date" name="tanggal_checkin" x-model="selectedPRI.tanggal_checkin" required
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Tgl Check-Out</label>
                                <input type="date" name="tanggal_checkout" x-model="selectedPRI.tanggal_checkout"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Diagnosa / Catatan Medis</label>
                            <input type="text" name="diagnosa" x-model="selectedPRI.diagnosa"
                                   class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Status Rawat</label>
                                <select name="status" x-model="selectedPRI.status" class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                                    <option value="dirawat">Masih Dirawat</option>
                                    <option value="selesai">Selesai / Pulang</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Total Pembayaran (Rp) *</label>
                                <input type="number" name="bayar" x-model="selectedPRI.bayar" required min="0"
                                       class="w-full text-sm font-mono border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-amber-500">
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end space-x-3">
                        <button type="button" @click="openEdit = false" class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-amber-600 hover:bg-amber-700 rounded-xl shadow">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
