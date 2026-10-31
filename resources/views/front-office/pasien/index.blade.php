@extends('layouts.app')

@section('title', 'Data Pasien - Front Office SIMHUIM')

@section('content')
<div x-data="{
    openTambah: false,
    openEdit: false,
    editData: {}
}">
    <!-- Header & Stat Cards -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Manajemen Data Pasien</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola biodata pasien terdaftar, nomor rekam medis, dan informasi kontak penanggung jawab.</p>
        </div>
        <div>
            <button @click="openTambah = true"
                    class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-teal-600 hover:bg-teal-700 shadow-sm hover:shadow transition-all">
                <i class="fa-solid fa-user-plus mr-2"></i> Tambah Pasien Baru
            </button>
        </div>
    </div>

    <!-- Quick Stat Badges -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pasien Terdaftar</span>
                <div class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalPasien }}</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kunjungan Rawat Jalan</span>
                <div class="text-2xl font-extrabold text-teal-600 mt-1">{{ $totalPRJ }}</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-stethoscope"></i>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Pasien Rawat Inap</span>
                <div class="text-2xl font-extrabold text-amber-600 mt-1">{{ $totalPRI }}</div>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                <i class="fa-solid fa-bed-pulse"></i>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <!-- Search Bar -->
        <div class="p-4 sm:p-6 border-b border-slate-200/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <form method="GET" action="{{ route('front-office.pasien.index') }}" class="relative max-w-sm w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input type="text" name="search" value="{{ $search }}"
                       placeholder="Cari nama, No. RM, alamat..."
                       class="block w-full pl-9 pr-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition">
            </form>
            <div class="text-xs text-slate-500 font-medium">
                Menampilkan {{ $pasiens->firstItem() ?? 0 }} - {{ $pasiens->lastItem() ?? 0 }} dari {{ $pasiens->total() }} data
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/80 text-xs uppercase font-bold text-slate-500 border-b border-slate-200 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">No. Rekam Medis</th>
                        <th class="py-3.5 px-4">Nama Pasien</th>
                        <th class="py-3.5 px-4">Gender</th>
                        <th class="py-3.5 px-4">Alamat</th>
                        <th class="py-3.5 px-4">No. Telepon</th>
                        <th class="py-3.5 px-4">Penanggung Jawab</th>
                        <th class="py-3.5 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pasiens as $index => $pasien)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 text-center font-medium text-slate-400">
                                {{ $pasiens->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4 font-mono font-semibold text-teal-700 text-xs">
                                <span class="bg-teal-50 px-2 py-1 rounded border border-teal-200">
                                    {{ $pasien->no_rekam_medis ?? ('RM-' . str_pad($pasien->id, 6, '0', STR_PAD_LEFT)) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900">{{ $pasien->nama_pasien }}</div>
                                @if($pasien->tgl_lahir)
                                    <div class="text-xs text-slate-500">{{ $pasien->tmp_lahir ? $pasien->tmp_lahir . ', ' : '' }}{{ $pasien->tgl_lahir->format('d/m/Y') }} ({{ $pasien->usia }} th)</div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                @if($pasien->jenis_kelamin == 'L')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                        <i class="fa-solid fa-mars mr-1"></i> L
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-pink-50 text-pink-700 border border-pink-200">
                                        <i class="fa-solid fa-venus mr-1"></i> P
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-xs text-slate-600 max-w-xs truncate">
                                {{ $pasien->alamat }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-xs">
                                {{ $pasien->no_telepon ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-xs">
                                @if($pasien->nama_pj_pasien)
                                    <span class="font-semibold text-slate-800">{{ $pasien->nama_pj_pasien }}</span>
                                    <span class="text-slate-400 text-[11px] block">({{ $pasien->hub_pj_pasien ?? 'Wali' }})</span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <button @click="editData = {{ json_encode($pasien) }}; openEdit = true"
                                            class="w-7 h-7 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-700 flex items-center justify-center transition"
                                            title="Edit Data Pasien">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>
                                    <form action="{{ route('front-office.pasien.destroy', $pasien->id) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pasien ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 flex items-center justify-center transition"
                                                title="Hapus Data Pasien">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-inbox text-3xl mb-2 block"></i>
                                Tidak ada data pasien yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pasiens->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $pasiens->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL TAMBAH DATA PASIEN -->
    <div x-show="openTambah" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="openTambah" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="openTambah = false"></div>

            <div x-show="openTambah" x-transition class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-100">
                <form action="{{ route('front-office.pasien.store') }}" method="POST">
                    @csrf
                    <div class="bg-teal-700 px-6 py-4 flex items-center justify-between text-white">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-user-plus text-lg"></i>
                            <h3 class="text-base font-bold">Pendaftaran Biodata Pasien Baru</h3>
                        </div>
                        <button type="button" @click="openTambah = false" class="text-teal-200 hover:text-white">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                        <div class="text-xs font-bold text-teal-800 uppercase tracking-wider pb-1 border-b border-slate-200">
                            1. Identitas Pasien
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Pasien Lengkap *</label>
                                <input type="text" name="nama_pasien" required placeholder="Contoh: Muhammad Ilyas Firdaus"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Tempat Lahir</label>
                                <input type="text" name="tmp_lahir" placeholder="Contoh: Sleman"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis Kelamin *</label>
                                <select name="jenis_kelamin" required class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Agama</label>
                                <select name="agama" class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Lengkap *</label>
                                <textarea name="alamat" rows="2" required placeholder="Jalan, RT/RW, Kelurahan, Kota..."
                                          class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"></textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Telepon / WhatsApp *</label>
                                <input type="text" name="no_telepon" required placeholder="08xxxxxxxx"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Pekerjaan</label>
                                <input type="text" name="pekerjaan" placeholder="Contoh: Karyawan Swasta"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Pendidikan Terakhir</label>
                                <input type="text" name="pend_terakhir" placeholder="SD / SMP / SMA / S1 / S2"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            </div>
                        </div>

                        <div class="text-xs font-bold text-teal-800 uppercase tracking-wider pb-1 pt-3 border-b border-slate-200">
                            2. Data Penanggung Jawab (Keluarga / Wali)
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Penanggung Jawab</label>
                                <input type="text" name="nama_pj_pasien" placeholder="Nama lengkap penanggung jawab"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Hubungan dengan Pasien</label>
                                <input type="text" name="hub_pj_pasien" placeholder="Orang Tua / Suami / Istri / Saudara"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Pekerjaan Penanggung Jawab</label>
                                <input type="text" name="pekerjaan_pj" placeholder="Pekerjaan penanggung jawab"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">No. Kontak Penanggung Jawab</label>
                                <input type="text" name="no_pj" placeholder="08xxxxxxxx"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end space-x-3">
                        <button type="button" @click="openTambah = false" class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-100 transition">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-teal-600 hover:bg-teal-700 rounded-xl shadow transition">
                            <i class="fa-solid fa-save mr-1.5"></i> Daftarkan Pasien
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT DATA PASIEN -->
    <div x-show="openEdit" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="openEdit" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="openEdit = false"></div>

            <div x-show="openEdit" x-transition class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-100">
                <form :action="'/front-office/pasien/' + editData.id" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-sky-700 px-6 py-4 flex items-center justify-between text-white">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-user-pen text-lg"></i>
                            <h3 class="text-base font-bold">Edit Biodata Pasien (<span x-text="editData.no_rekam_medis || ('RM-' + editData.id)"></span>)</h3>
                        </div>
                        <button type="button" @click="openEdit = false" class="text-sky-200 hover:text-white">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Pasien *</label>
                                <input type="text" name="nama_pasien" x-model="editData.nama_pasien" required
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Tempat Lahir</label>
                                <input type="text" name="tmp_lahir" x-model="editData.tmp_lahir"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-sky-500">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" x-model="editData.tgl_lahir"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-sky-500">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis Kelamin *</label>
                                <select name="jenis_kelamin" x-model="editData.jenis_kelamin" required class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-sky-500">
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Agama</label>
                                <select name="agama" x-model="editData.agama" class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-sky-500">
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat *</label>
                                <textarea name="alamat" x-model="editData.alamat" rows="2" required
                                          class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-sky-500"></textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Telepon *</label>
                                <input type="text" name="no_telepon" x-model="editData.no_telepon" required
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-sky-500">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Pekerjaan</label>
                                <input type="text" name="pekerjaan" x-model="editData.pekerjaan"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-sky-500">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Pendidikan Terakhir</label>
                                <input type="text" name="pend_terakhir" x-model="editData.pend_terakhir"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-sky-500">
                            </div>
                        </div>

                        <div class="text-xs font-bold text-slate-700 uppercase tracking-wider pb-1 pt-3 border-b border-slate-200">
                            Data Penanggung Jawab
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Nama PJ</label>
                                <input type="text" name="nama_pj_pasien" x-model="editData.nama_pj_pasien"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-sky-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Hubungan</label>
                                <input type="text" name="hub_pj_pasien" x-model="editData.hub_pj_pasien"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-sky-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Pekerjaan PJ</label>
                                <input type="text" name="pekerjaan_pj" x-model="editData.pekerjaan_pj"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-sky-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">No. Kontak PJ</label>
                                <input type="text" name="no_pj" x-model="editData.no_pj"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-sky-500">
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end space-x-3">
                        <button type="button" @click="openEdit = false" class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-100 transition">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-sky-600 hover:bg-sky-700 rounded-xl shadow transition">
                            <i class="fa-solid fa-save mr-1.5"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
