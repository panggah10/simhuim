@extends('layouts.app')

@section('title', 'Manajemen Pengguna - Admin SIMHUIM')

@section('content')
<div x-data="{
    openTambah: false,
    openEdit: false,
    selectedUser: {}
}">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="inline-flex items-center space-x-2 text-xs font-bold text-purple-800 bg-purple-100/80 px-2.5 py-1 rounded-full mb-1">
                <i class="fa-solid fa-users-gear"></i>
                <span>MANAJEMEN PENGGUNA</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Kelola Akun & Hak Akses Pengguna</h1>
            <p class="text-sm text-slate-500 mt-0.5">Atur kredensial akun dokter, petugas front office, administrator, dan poliklinik.</p>
        </div>
        <div>
            <button @click="openTambah = true"
                    class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-purple-600 hover:bg-purple-700 shadow-sm transition-all">
                <i class="fa-solid fa-user-plus mr-2"></i> Tambah Pengguna Baru
            </button>
        </div>
    </div>

    <!-- Filter Pills & Search -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden mb-6">
        <div class="p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100">
            <!-- Role Filters -->
            <div class="flex flex-wrap items-center gap-1.5 text-xs font-medium">
                <a href="{{ route('admin.users.index') }}"
                   class="px-3 py-1.5 rounded-lg transition {{ empty($role) ? 'bg-purple-600 text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua Role ({{ \App\Models\User::count() }})
                </a>
                @foreach($rolesList as $r)
                    <a href="{{ route('admin.users.index', ['role' => $r]) }}"
                       class="px-3 py-1.5 rounded-lg transition {{ $role === $r ? 'bg-purple-600 text-white font-bold' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        {{ $r }} ({{ \App\Models\User::where('role', $r)->count() }})
                    </a>
                @endforeach
            </div>

            <!-- Search Bar -->
            <form method="GET" action="{{ route('admin.users.index') }}" class="relative max-w-xs w-full">
                @if($role)
                    <input type="hidden" name="role" value="{{ $role }}">
                @endif
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input type="text" name="search" value="{{ $search }}"
                       placeholder="Cari nama, username..."
                       class="block w-full pl-9 pr-3.5 py-1.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-500 bg-slate-50 focus:bg-white transition">
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50 text-xs uppercase font-bold text-slate-500 border-b border-slate-200 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">Nama Lengkap</th>
                        <th class="py-3.5 px-4">Username & Email</th>
                        <th class="py-3.5 px-4">Hak Akses (Role)</th>
                        <th class="py-3.5 px-4">Bagian / Unit</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $index => $u)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 text-center font-medium text-slate-400">
                                {{ $users->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                {{ $u->name }}
                            </td>
                            <td class="py-3.5 px-4 text-xs font-mono">
                                <span class="font-bold text-purple-900 block">{{ $u->username }}</span>
                                <span class="text-slate-400 text-[11px]">{{ $u->email ?? '-' }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($u->role === 'Admin')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-purple-100 text-purple-800">
                                        <i class="fa-solid fa-shield-halved mr-1 text-[10px]"></i> Admin
                                    </span>
                                @elseif($u->role === 'Front Office')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-emerald-100 text-emerald-800">
                                        <i class="fa-solid fa-hospital-user mr-1 text-[10px]"></i> Front Office
                                    </span>
                                @elseif($u->role === 'Dokter')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-sky-100 text-sky-800">
                                        <i class="fa-solid fa-user-doctor mr-1 text-[10px]"></i> Dokter
                                    </span>
                                @elseif($u->role === 'Departemen')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-amber-100 text-amber-800">
                                        <i class="fa-solid fa-clinic-medical mr-1 text-[10px]"></i> Departemen
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-xs text-slate-600">
                                {{ $u->grup ?: '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($u->status)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span> Non-Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <button @click="selectedUser = {{ json_encode($u) }}; openEdit = true"
                                            class="w-7 h-7 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-700 flex items-center justify-center transition"
                                            title="Edit Pengguna">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>
                                    @if(auth()->id() !== $u->id)
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pengguna ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 flex items-center justify-center transition"
                                                    title="Hapus Pengguna">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-users text-3xl mb-2 block"></i>
                                Tidak ada data pengguna yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL TAMBAH PENGGUNA -->
    <div x-show="openTambah" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="openTambah = false"></div>

            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl max-w-lg w-full border border-slate-100">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="bg-purple-700 px-6 py-4 flex items-center justify-between text-white">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-user-plus text-lg"></i>
                            <h3 class="text-base font-bold">Tambah Akun Pengguna Baru</h3>
                        </div>
                        <button type="button" @click="openTambah = false" class="text-purple-200 hover:text-white">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap *</label>
                            <input type="text" name="name" required placeholder="Contoh: dr. Budi Santoso, Sp.A"
                                   class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-purple-500">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Username *</label>
                                <input type="text" name="username" required placeholder="username"
                                       class="w-full text-sm font-mono border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-purple-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                                <input type="email" name="email" placeholder="user@uim.ac.id"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-purple-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Hak Akses (Role) *</label>
                                <select name="role" required class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-purple-500">
                                    <option value="Admin">Admin</option>
                                    <option value="Front Office">Front Office</option>
                                    <option value="Dokter">Dokter</option>
                                    <option value="Departemen">Departemen / Poli</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Grup / Unit / Poli</label>
                                <input type="text" name="grup" placeholder="Umum / Kandungan / dll"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-purple-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Password *</label>
                                <input type="password" name="password" required placeholder="••••••••"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-purple-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Status Akun *</label>
                                <select name="status" required class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-purple-500">
                                    <option value="1">Aktif</option>
                                    <option value="0">Non-Aktif</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end space-x-3">
                        <button type="button" @click="openTambah = false" class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-purple-600 hover:bg-purple-700 rounded-xl shadow">
                            <i class="fa-solid fa-save mr-1.5"></i> Simpan Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT PENGGUNA -->
    <div x-show="openEdit" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="openEdit = false"></div>

            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl max-w-lg w-full border border-slate-100">
                <form :action="'/admin/users/' + selectedUser.id" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-sky-700 px-6 py-4 flex items-center justify-between text-white">
                        <h3 class="text-base font-bold">Edit Akun Pengguna</h3>
                        <button type="button" @click="openEdit = false" class="text-sky-200 hover:text-white">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap *</label>
                            <input type="text" name="name" x-model="selectedUser.name" required
                                   class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Username *</label>
                                <input type="text" name="username" x-model="selectedUser.username" required
                                       class="w-full text-sm font-mono border border-slate-300 rounded-xl px-3.5 py-2">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                                <input type="email" name="email" x-model="selectedUser.email"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Hak Akses (Role) *</label>
                                <select name="role" x-model="selectedUser.role" required class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                                    <option value="Admin">Admin</option>
                                    <option value="Front Office">Front Office</option>
                                    <option value="Dokter">Dokter</option>
                                    <option value="Departemen">Departemen / Poli</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Grup / Unit</label>
                                <input type="text" name="grup" x-model="selectedUser.grup"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Password Baru (Kosongkan jika tidak diubah)</label>
                                <input type="password" name="password" placeholder="••••••••"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Status Akun *</label>
                                <select name="status" x-model="selectedUser.status" required class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                                    <option :value="1">Aktif</option>
                                    <option :value="0">Non-Aktif</option>
                                </select>
                            </div>
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
