@extends('layouts.app')

@section('title', 'Manajemen E-Resep Obat - SIMHUIM')

@section('content')
<div x-data="{
    openTambah: false,
    openEdit: false,
    selectedResep: {},
}">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Manajemen E-Resep Dokter</h1>
            <p class="text-sm text-slate-500 mt-1">Terbitkan resep medis elektronik dan cetak lembar resep berstandar rumah sakit (PDF).</p>
        </div>
        <div>
            <button @click="openTambah = true"
                    class="inline-flex items-center px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-teal-600 hover:bg-teal-700 shadow-sm transition-all">
                <i class="fa-solid fa-plus-circle mr-2"></i> Tulis Resep Baru
            </button>
        </div>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <!-- Search Bar -->
        <div class="p-4 sm:p-6 border-b border-slate-200/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <form method="GET" action="{{ route('dokter.resep.index') }}" class="relative max-w-sm w-full">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input type="text" name="search" value="{{ $search }}"
                       placeholder="Cari pasien, obat, atau resep..."
                       class="block w-full pl-9 pr-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-slate-50 focus:bg-white transition">
            </form>
            <div class="text-xs text-slate-500 font-medium">
                Total: {{ $reseps->total() }} resep obat diterbitkan
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700">
                <thead class="bg-slate-50/80 text-xs uppercase font-bold text-slate-500 border-b border-slate-200 tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4">No. Resep / Tgl</th>
                        <th class="py-3.5 px-4">Pasien Penerima</th>
                        <th class="py-3.5 px-4">Judul Resep</th>
                        <th class="py-3.5 px-4">Rincian Obat & Dosis</th>
                        <th class="py-3.5 px-4 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reseps as $index => $resep)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 text-center font-medium text-slate-400">
                                {{ $reseps->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-xs">
                                <span class="font-bold text-teal-800 block">RSP-{{ str_pad($resep->id, 5, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-slate-400 text-[11px]">{{ $resep->tanggal->format('d/m/Y') }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900">{{ $resep->pasien->nama_pasien ?? 'Pasien' }}</div>
                                <div class="text-xs text-slate-400 font-mono">{{ $resep->pasien->no_rekam_medis ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-800 text-xs">
                                {{ $resep->nama_resep }}
                            </td>
                            <td class="py-3.5 px-4 text-xs">
                                <div class="bg-slate-50 p-2 rounded-lg border border-slate-200/80 text-slate-700 whitespace-pre-line font-mono text-[11px] max-w-md">
                                    {{ $resep->rincian_resep }}
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center space-x-1.5">
                                    <a href="{{ route('dokter.resep.cetak', $resep->id) }}" target="_blank"
                                       class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 transition"
                                       title="Cetak Resep PDF">
                                        <i class="fa-solid fa-file-pdf mr-1"></i> PDF
                                    </a>
                                    <button @click="selectedResep = {{ json_encode($resep) }}; openEdit = true"
                                            class="w-7 h-7 rounded-lg bg-sky-50 hover:bg-sky-100 text-sky-700 flex items-center justify-center transition"
                                            title="Edit Resep">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>
                                    <form action="{{ route('dokter.resep.destroy', $resep->id) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus resep obat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-7 h-7 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 flex items-center justify-center transition"
                                                title="Hapus Resep">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-prescription text-3xl mb-2 block"></i>
                                Belum ada resep obat yang diterbitkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($reseps->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $reseps->links() }}
            </div>
        @endif
    </div>

    <!-- MODAL TULIS RESEP BARU -->
    <div x-show="openTambah" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="openTambah = false"></div>

            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl max-w-lg w-full border border-slate-100">
                <form action="{{ route('dokter.resep.store') }}" method="POST">
                    @csrf
                    <div class="bg-teal-700 px-6 py-4 flex items-center justify-between text-white">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-prescription text-lg"></i>
                            <h3 class="text-base font-bold">Penerbitan E-Resep Obat Dokter</h3>
                        </div>
                        <button type="button" @click="openTambah = false" class="text-teal-200 hover:text-white">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Pasien Penerima Resep *</label>
                            <select name="pasien_id" required class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500">
                                <option value="">-- Pilih Pasien --</option>
                                @foreach($pasiens as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_pasien }} ({{ $p->no_rekam_medis ?? ('RM-' . $p->id) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Judul / Nama Resep *</label>
                                <input type="text" name="nama_resep" required placeholder="Contoh: Resep Radang Tenggorokan"
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Resep *</label>
                                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2 focus:ring-2 focus:ring-teal-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Rincian Obat, Dosis & Aturan Minum *</label>
                            <textarea name="rincian_resep" rows="5" required
                                      placeholder="Contoh:&#10;- Amoxicillin 500mg 3x1 tablet sesudah makan (habiskan)&#10;- Paracetamol 500mg 3x1 tablet (bila demam)&#10;- Ambroxol 30mg 3x1 tablet"
                                      class="w-full text-sm font-mono border border-slate-300 rounded-xl px-3.5 py-2.5 focus:ring-2 focus:ring-teal-500"></textarea>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end space-x-3">
                        <button type="button" @click="openTambah = false" class="px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-300 rounded-xl">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-teal-600 hover:bg-teal-700 rounded-xl shadow">
                            <i class="fa-solid fa-save mr-1.5"></i> Terbitkan Resep
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT RESEP -->
    <div x-show="openEdit" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4 text-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="openEdit = false"></div>

            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl max-w-lg w-full border border-slate-100">
                <form :action="'/dokter/resep/' + selectedResep.id" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-sky-700 px-6 py-4 flex items-center justify-between text-white">
                        <h3 class="text-base font-bold">Edit Resep Medis</h3>
                        <button type="button" @click="openEdit = false" class="text-sky-200 hover:text-white">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Judul Resep *</label>
                                <input type="text" name="nama_resep" x-model="selectedResep.nama_resep" required
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Resep *</label>
                                <input type="date" name="tanggal" x-model="selectedResep.tanggal" required
                                       class="w-full text-sm border border-slate-300 rounded-xl px-3.5 py-2">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Rincian Obat & Dosis *</label>
                            <textarea name="rincian_resep" x-model="selectedResep.rincian_resep" rows="5" required
                                      class="w-full text-sm font-mono border border-slate-300 rounded-xl px-3.5 py-2.5"></textarea>
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
