<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\RawatInap;
use App\Models\RawatJalan;
use App\Models\Resep;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ==========================================
    // 1. DASHBOARD & ANALITIK RUMAH SAKIT
    // ==========================================
    public function dashboard()
    {
        $totalPasien = Pasien::count();
        $totalDokter = Dokter::count();
        $totalPRJ = RawatJalan::count();
        $totalPRI = RawatInap::count();
        $totalResep = Resep::count();
        $totalUser = User::count();

        $pendapatanPRJ = RawatJalan::sum('bayar');
        $pendapatanPRI = RawatInap::sum('bayar');
        $totalPendapatan = $pendapatanPRJ + $pendapatanPRI;

        // Kunjungan per Poli
        $poliStats = RawatJalan::selectRaw('departemen, count(*) as total, sum(bayar) as pendapatan')
            ->groupBy('departemen')
            ->orderByDesc('total')
            ->get();

        // Aktivitas Terbaru
        $recentPatients = Pasien::latest()->take(5)->get();
        $recentPRJ = RawatJalan::with(['pasien', 'dokter'])->latest('tanggal')->take(5)->get();
        $recentPRI = RawatInap::with(['pasien', 'tarif'])->latest('tanggal_checkin')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPasien',
            'totalDokter',
            'totalPRJ',
            'totalPRI',
            'totalResep',
            'totalUser',
            'pendapatanPRJ',
            'pendapatanPRI',
            'totalPendapatan',
            'poliStats',
            'recentPatients',
            'recentPRJ',
            'recentPRI'
        ));
    }

    // ==========================================
    // 2. MANAJEMEN PENGGUNA (USER MANAGEMENT)
    // ==========================================
    public function usersIndex(Request $request)
    {
        $search = $request->query('search');
        $role = $request->query('role');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->when($role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $rolesList = ['Admin', 'Front Office', 'Dokter', 'Departemen'];

        return view('admin.users.index', compact('users', 'rolesList', 'search', 'role'));
    }

    public function usersStore(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'email' => ['nullable', 'email', 'max:100', 'unique:users,email'],
            'role' => ['required', 'in:Admin,Front Office,Dokter,Departemen'],
            'grup' => ['nullable', 'string', 'max:100'],
            'password' => ['required', 'string', 'min:4'],
            'status' => ['required', 'boolean'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        // Jika dibuat sebagai dokter, otomatis buat record di tabel dokters
        if ($user->role === 'Dokter') {
            Dokter::create([
                'user_id' => $user->id,
                'nama_dokter' => $user->name,
                'departemen' => $user->grup ?? 'Umum',
                'jadwal_praktik' => 'Senin - Kamis | 08.00 - 15.00',
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun pengguna ' . $user->name . ' (' . $user->role . ') berhasil ditambahkan.');
    }

    public function usersUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username,' . $id],
            'email' => ['nullable', 'email', 'max:100', 'unique:users,email,' . $id],
            'role' => ['required', 'in:Admin,Front Office,Dokter,Departemen'],
            'grup' => ['nullable', 'string', 'max:100'],
            'password' => ['nullable', 'string', 'min:4'],
            'status' => ['required', 'boolean'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data akun ' . $user->name . ' berhasil diperbarui.');
    }

    public function usersDestroy($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $nama = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun ' . $nama . ' berhasil dihapus.');
    }

    // ==========================================
    // 3. MANAJEMEN DOKTER
    // ==========================================
    public function doktersIndex(Request $request)
    {
        $search = $request->query('search');

        $dokters = Dokter::with('user')
            ->when($search, function ($query, $search) {
                $query->where('nama_dokter', 'like', "%{$search}%")
                    ->orWhere('departemen', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $users = User::where('role', 'Dokter')->get();

        return view('admin.dokters.index', compact('dokters', 'users', 'search'));
    }

    public function doktersStore(Request $request)
    {
        $validated = $request->validate([
            'nama_dokter' => ['required', 'string', 'max:100'],
            'departemen' => ['required', 'string', 'max:50'],
            'jadwal_praktik' => ['required', 'string', 'max:100'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        Dokter::create($validated);

        return redirect()->route('admin.dokters.index')
            ->with('success', 'Data dokter ' . $validated['nama_dokter'] . ' berhasil ditambahkan.');
    }

    public function doktersUpdate(Request $request, $id)
    {
        $dokter = Dokter::findOrFail($id);

        $validated = $request->validate([
            'nama_dokter' => ['required', 'string', 'max:100'],
            'departemen' => ['required', 'string', 'max:50'],
            'jadwal_praktik' => ['required', 'string', 'max:100'],
            'user_id' => ['nullable', 'exists:users,id'],
        ]);

        $dokter->update($validated);

        return redirect()->route('admin.dokters.index')
            ->with('success', 'Data dokter ' . $dokter->nama_dokter . ' berhasil diperbarui.');
    }

    public function doktersDestroy($id)
    {
        $dokter = Dokter::findOrFail($id);
        $nama = $dokter->nama_dokter;
        $dokter->delete();

        return redirect()->route('admin.dokters.index')
            ->with('success', 'Data dokter ' . $nama . ' berhasil dihapus.');
    }

    // ==========================================
    // 4. MANAJEMEN MASTER TARIF
    // ==========================================
    public function tarifsIndex()
    {
        $tarifRJ = Tarif::rawatJalan()->latest()->get();
        $tarifRI = Tarif::rawatInap()->latest()->get();

        return view('admin.tarifs.index', compact('tarifRJ', 'tarifRI'));
    }

    public function tarifsStore(Request $request)
    {
        $validated = $request->validate([
            'jenis' => ['required', 'in:rawat_jalan,rawat_inap'],
            'departemen' => ['nullable', 'string', 'max:50'],
            'perawatan' => ['nullable', 'string', 'max:50'],
            'pelayanan' => ['nullable', 'string', 'max:60'],
            'tipe_kamar' => ['nullable', 'string', 'max:50'],
            'kapasitas' => ['nullable', 'integer', 'min:1'],
            'tarif' => ['required', 'numeric', 'min:0'],
        ]);

        Tarif::create($validated);

        return redirect()->route('admin.tarifs.index')
            ->with('success', 'Master tarif baru berhasil ditambahkan.');
    }

    public function tarifsUpdate(Request $request, $id)
    {
        $tarif = Tarif::findOrFail($id);

        $validated = $request->validate([
            'jenis' => ['required', 'in:rawat_jalan,rawat_inap'],
            'departemen' => ['nullable', 'string', 'max:50'],
            'perawatan' => ['nullable', 'string', 'max:50'],
            'pelayanan' => ['nullable', 'string', 'max:60'],
            'tipe_kamar' => ['nullable', 'string', 'max:50'],
            'kapasitas' => ['nullable', 'integer', 'min:1'],
            'tarif' => ['required', 'numeric', 'min:0'],
        ]);

        $tarif->update($validated);

        return redirect()->route('admin.tarifs.index')
            ->with('success', 'Master tarif berhasil diperbarui.');
    }

    public function tarifsDestroy($id)
    {
        $tarif = Tarif::findOrFail($id);
        $tarif->delete();

        return redirect()->route('admin.tarifs.index')
            ->with('success', 'Master tarif berhasil dihapus.');
    }
}
