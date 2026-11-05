@extends('layouts.app')

@section('title', 'Kelola Master Tarif - Admin SIMHUIM')

@section('content')
<div x-data="{
    tab: 'rj',
    openTambah: false,
    openEdit: false,
    selectedTarif: {},
    newJenis: 'rawat_jalan',
}">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="inline-flex items-center space-x-2 text-xs font-bold text-teal-800 bg-teal-100/80 px-2.5 py-1 rounded-full mb-1">
                <i class="fa-solid fa-receipt"></i>
                <span>MASTER DATA TARIF</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Kelola Standar Biaya & Tarif RS</h1>
            <p class="text-sm text-slate-500 mt-0.5">Atur besaran tarif registrasi poliklinik dan tarif akomodasi rawat inap.</p>
        </div>
        <div>
            <button @click="openTambah = true"
                    class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-teal-600 hover:bg-teal-700 shadow-sm transition-all">
                <i class="fa-solid fa-plus-circle mr-2"></i> Tambah Tarif Baru
            </button>
        </div>
    </div>

    <!-- Tab Buttons -->
    <div class="flex space-x-2 border-b border-slate-200 mb-6">
        <button @click="tab = 'rj'"
                :class="tab === 'rj' ? 'border-teal-600 text-teal-700 font-bold' : 'border-transparent text-slate-500 hover:text-slate-700'"
                class="py-3 px-4 text-sm border-b-2 font-medium transition flex items-center space-x-2">
            <i class="fa-solid fa-stethoscope"></i>
            <span>Tarif Poliklinik Rawat Jalan ({{ $tarifRJ->count() }})</span>
        </button>
        <button @click="tab = 'ri'"
                :class="tab === 'ri' ? 'border-teal-600 text-teal-700 font-bold' : 'border-transparent text-slate-500 hover:text-slate-700'"
                class="py-3 px-4 text-sm border-b-2 font-medium transition flex items-center space-x-2">
            <i class="fa-solid fa-bed-pulse"></i>
            <span>Tarif Kamar Rawat Inap ({{ $tarifRI->count() }})</span>
        </button>
    </div>

    <!-- Tab 1: Rawat Jalan -->
    <div x-show="tab === 'rj'" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4 w-12 text-center">No</th>
                        <th class="py-3 px-4">Poliklinik / Departemen</th>
                        <th class="py-3 px-4 text-right">Tarif Dasar</th>
                        <th class="py-3 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tarifRJ as $index => $t)
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-3 px-4 text-center text-slate-400 font-medium">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-900">
                                <i class="fa-regular fa-hospital text-teal-600 mr-2"></i> Poli {{ $t->departemen }}
                            </td>
                            <td class="py-3 px-4 text-right font-mono font-bold text-teal-700">
                                Rp {{ number_format($t->tarif, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <button @click="selectedTarif = {{ json_encode($t) }}; openEdit = true"
                                            class="w-7 h-7 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-700 flex items-center justify-center transition"
                                            title="Edit Tarif">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>
                                    <form action="{{ route('admin.tarifs.destroy', $t->id) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus tarif ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 flex items-center justify-center transition"
                                                title="Hapus Tarif">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400">Belum ada tarif poliklinik.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tab 2: Rawat Inap -->
    <div x-show="tab === 'ri'" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden mb-6" x-cloak>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4 w-12 text-center">No</th>
                        <th class="py-3 px-4">Instalasi / Perawatan</th>
                        <th class="py-3 px-4">Pelayanan</th>
                        <th class="py-3 px-4">Tipe Kamar</th>
                        <th class="py-3 px-4 text-center">Kapasitas</th>
                        <th class="py-3 px-4 text-right">Tarif / Hari</th>
                        <th class="py-3 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tarifRI as $index => $t)
                        <tr class="hover:bg-slate-50/80">
                            <td class="py-3 px-4 text-center text-slate-400 font-medium">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-900">{{ $t->perawatan }}</td>
                            <td class="py-3 px-4 text-xs text-slate-600">{{ $t->pelayanan }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-xs font-semibold bg-slate-100 text-slate-800 border border-slate-200">
                                    {{ $t->tipe_kamar ?: 'Standar' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center font-mono text-xs">{{ $t->kapasitas }} Bed</td>
                            <td class="py-3 px-4 text-right font-mono font-bold text-teal-700">
                                Rp {{ number_format($t->tarif, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <button @click="selectedTarif = {{ json_encode($t) }}; openEdit = true"
                                            class="w-7 h-7 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-700 flex items-center justify-center transition"
                                            title="Edit Tarif">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>
                                    <form action="{{ route('admin.tarifs.destroy', $t->id) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus tarif ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 flex items-center justify-center transition"
                                                title="Hapus Tarif">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">Belum ada tarif rawat inap.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL TAMBAH TARIF -->
    <div x-show="openTambah" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="openTambah = false"></div>

            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl max-w-lg w-full border border-slate-100">
                <form action="{{ route('admin.tarifs.store') }}" method="POST">
                    @csrf
                    <div class="bg-teal-700 px-6 py-4 flex items-center justify-between text-white">
                        <h3 class="text-base font-bold">Tambah Master Tarif Baru</h3>
                        <button type="button" @click="openTambah = false" class="text-teal-200 hover:text-white">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis Layanan *</label>
                            <select name="jenis" x-model="newJenis" required class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                                <option value="rawat_jalan">Rawat Jalan (Poliklinik)</option>
                                <option value="rawat_inap">Rawat Inap (Kamar & Perawatan)</option>
                            </select>
                        </div>

                        <!-- Fields untuk Rawat Jalan -->
                        <div x-show="newJenis === 'rawat_jalan'">
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Poliklinik / Departemen *</label>
                            <input type="text" name="departemen" placeholder="Contoh: Mata / Jantung"
                                   class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                        </div>

                        <!-- Fields untuk Rawat Inap -->
                        <div x-show="newJenis === 'rawat_inap'" class="space-y-3" x-cloak>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Perawatan</label>
                                <input type="text" name="perawatan" placeholder="Contoh: Rawat Inap per hari"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Pelayanan</label>
                                <input type="text" name="pelayanan" placeholder="Contoh: Dokter Spesialis dan Umum"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tipe / Kelas Kamar</label>
                                    <input type="text" name="tipe_kamar" placeholder="Kelas VVIP / Kelas I"
                                           class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kapasitas Bed</label>
                                    <input type="number" name="kapasitas" min="1" value="1"
                                           class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Besaran Tarif (Rp) *</label>
                            <input type="number" name="tarif" min="0" required placeholder="0"
                                   class="w-full text-sm font-mono border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end space-x-3">
                        <button type="button" @click="openTambah = false" class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-teal-600 hover:bg-teal-700 rounded-xl shadow">
                            Simpan Tarif
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT TARIF -->
    <div x-show="openEdit" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="openEdit = false"></div>

            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl max-w-lg w-full border border-slate-100">
                <form :action="'/admin/tarifs/' + selectedTarif.id" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-sky-700 px-6 py-4 flex items-center justify-between text-white">
                        <h3 class="text-base font-bold">Edit Master Tarif</h3>
                        <button type="button" @click="openEdit = false" class="text-sky-200 hover:text-white">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <input type="hidden" name="jenis" x-model="selectedTarif.jenis">

                        <div x-show="selectedTarif.jenis === 'rawat_jalan'">
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Poliklinik</label>
                            <input type="text" name="departemen" x-model="selectedTarif.departemen"
                                   class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                        </div>

                        <div x-show="selectedTarif.jenis === 'rawat_inap'" class="space-y-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Perawatan</label>
                                <input type="text" name="perawatan" x-model="selectedTarif.perawatan"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Pelayanan</label>
                                <input type="text" name="pelayanan" x-model="selectedTarif.pelayanan"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tipe / Kelas Kamar</label>
                                    <input type="text" name="tipe_kamar" x-model="selectedTarif.tipe_kamar"
                                           class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kapasitas</label>
                                    <input type="number" name="kapasitas" x-model="selectedTarif.kapasitas"
                                           class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Besaran Tarif (Rp) *</label>
                            <input type="number" name="tarif" x-model="selectedTarif.tarif" required min="0"
                                   class="w-full text-sm font-mono border border-slate-300 rounded-xl px-3.5 py-2">
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end space-x-3">
                        <button type="button" @click="openEdit = false" class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-sky-600 hover:bg-sky-700 rounded-xl shadow">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
