@extends('layouts.app')

@section('title', 'Kelola Tenaga Medis - Admin SIMHUIM')

@section('content')
<div x-data="{
    openTambah: false,
    openEdit: false,
    selectedDokter: {}
}">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="inline-flex items-center space-x-2 text-xs font-bold text-sky-800 bg-sky-100/80 px-2.5 py-1 rounded-full mb-1">
                <i class="fa-solid fa-user-doctor"></i>
                <span>MANAJEMEN TENAGA MEDIS</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Kelola Profil & Jadwal Dokter</h1>
            <p class="text-sm text-slate-500 mt-0.5">Daftar dokter spesialis, jadwal praktik mingguan, dan integrasi akun sistem.</p>
        </div>
        <div>
            <button @click="openTambah = true"
                    class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-sky-600 hover:bg-sky-700 shadow-sm transition-all">
                <i class="fa-solid fa-plus-circle mr-2"></i> Tambah Dokter Baru
            </button>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden mb-6">
        <div class="p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100">
            <form method="GET" action="{{ route('admin.dokters.index') }}" class="relative max-w-sm w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input type="text" name="search" value="{{ $search }}"
                       placeholder="Cari dokter, departemen/poli..."
                       class="block w-full pl-9 pr-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 bg-slate-50 focus:bg-white transition">
            </form>
            <div class="text-xs text-slate-500 font-medium">
                Total: {{ $dokters->total() }} dokter spesialis terdaftar
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Nama Dokter & Gelar</th>
                        <th class="py-3.5 px-4">Poliklinik / Departemen</th>
                        <th class="py-3.5 px-4">Jadwal Praktik</th>
                        <th class="py-3.5 px-4">Akun Login</th>
                        <th class="py-3.5 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($dokters as $index => $d)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 text-center font-medium text-slate-400">
                                {{ $dokters->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                {{ $d->nama_dokter }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-semibold bg-sky-50 text-sky-800 border border-sky-200">
                                    Poli {{ $d->departemen }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-xs font-medium text-slate-700">
                                <i class="fa-solid fa-calendar-days text-slate-400 mr-1.5"></i>
                                {{ $d->jadwal_praktik }}
                            </td>
                            <td class="py-3.5 px-4 text-xs font-mono">
                                @if($d->user)
                                    <span class="text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                        {{ $d->user->username }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">Belum terhubung</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <button @click="selectedDokter = {{ json_encode($d) }}; openEdit = true"
                                            class="w-7 h-7 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-700 flex items-center justify-center transition"
                                            title="Edit Dokter">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>
                                    <form action="{{ route('admin.dokters.destroy', $d->id) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data dokter ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 flex items-center justify-center transition"
                                                title="Hapus Dokter">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-user-doctor text-3xl mb-2 block"></i>
                                Tidak ada data dokter yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($dokters->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $dokters->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL TAMBAH DOKTER -->
    <div x-show="openTambah" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="openTambah = false"></div>

            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl max-w-lg w-full border border-slate-100">
                <form action="{{ route('admin.dokters.store') }}" method="POST">
                    @csrf
                    <div class="bg-sky-700 px-6 py-4 flex items-center justify-between text-white">
                        <h3 class="text-base font-bold">Tambah Dokter Baru</h3>
                        <button type="button" @click="openTambah = false" class="text-sky-200 hover:text-white">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Dokter & Gelar *</label>
                            <input type="text" name="nama_dokter" required placeholder="Contoh: dr. Ahmad Farhan, Sp.PD"
                                   class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Spesialisasi / Poliklinik *</label>
                            <input type="text" name="departemen" required placeholder="Contoh: Umum / Gigi / Kandungan / Anak"
                                   class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Jadwal Praktik *</label>
                            <input type="text" name="jadwal_praktik" required value="Senin - Kamis | 08.00 - 15.00"
                                   class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Hubungkan ke Akun Pengguna</label>
                            <select name="user_id" class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                                <option value="">-- Tanpa Akun / Buat Nanti --</option>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->username }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end space-x-3">
                        <button type="button" @click="openTambah = false" class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-sky-600 hover:bg-sky-700 rounded-xl shadow">
                            Simpan Data Dokter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT DOKTER -->
    <div x-show="openEdit" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="openEdit = false"></div>

            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl max-w-lg w-full border border-slate-100">
                <form :action="'/admin/dokters/' + selectedDokter.id" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-sky-700 px-6 py-4 flex items-center justify-between text-white">
                        <h3 class="text-base font-bold">Edit Profil Dokter</h3>
                        <button type="button" @click="openEdit = false" class="text-sky-200 hover:text-white">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Dokter *</label>
                            <input type="text" name="nama_dokter" x-model="selectedDokter.nama_dokter" required
                                   class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Spesialisasi / Poli *</label>
                            <input type="text" name="departemen" x-model="selectedDokter.departemen" required
                                   class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Jadwal Praktik *</label>
                            <input type="text" name="jadwal_praktik" x-model="selectedDokter.jadwal_praktik" required
                                   class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Akun Pengguna Terhubung</label>
                            <select name="user_id" x-model="selectedDokter.user_id" class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                                <option value="">-- Tidak Terhubung --</option>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->username }})</option>
                                @endforeach
                            </select>
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
