<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\RawatInap;
use App\Models\RawatJalan;
use App\Models\Tarif;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FrontOfficeController extends Controller
{
    // ==========================================
    // 1. MANAJEMEN PASIEN
    // ==========================================
    public function pasienIndex(Request $request)
    {
        $search = $request->query('search');

        $pasiens = Pasien::query()
            ->when($search, function ($query, $search) {
                $query->where('nama_pasien', 'like', "%{$search}%")
                    ->orWhere('no_rekam_medis', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('no_telepon', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalPasien = Pasien::count();
        $totalPRJ = RawatJalan::count();
        $totalPRI = RawatInap::count();

        return view('front-office.pasien.index', compact('pasiens', 'search', 'totalPasien', 'totalPRJ', 'totalPRI'));
    }

    public function pasienStore(Request $request)
    {
        $validated = $request->validate([
            'nama_pasien' => ['required', 'string', 'max:100'],
            'tmp_lahir' => ['nullable', 'string', 'max:50'],
            'tgl_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'alamat' => ['required', 'string'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'agama' => ['nullable', 'string', 'max:30'],
            'pend_terakhir' => ['nullable', 'string', 'max:50'],
            'pekerjaan' => ['nullable', 'string', 'max:50'],
            'nama_pj_pasien' => ['nullable', 'string', 'max:100'],
            'hub_pj_pasien' => ['nullable', 'string', 'max:50'],
            'pekerjaan_pj' => ['nullable', 'string', 'max:50'],
            'no_pj' => ['nullable', 'string', 'max:20'],
        ]);

        // Generate nomor rekam medis otomatis
        $lastId = Pasien::max('id') ?? 0;
        $validated['no_rekam_medis'] = 'RM-' . str_pad($lastId + 1, 6, '0', STR_PAD_LEFT);

        Pasien::create($validated);

        return redirect()->route('front-office.pasien.index')
            ->with('success', 'Data pasien baru berhasil didaftarkan dengan No. RM: ' . $validated['no_rekam_medis']);
    }

    public function pasienUpdate(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);

        $validated = $request->validate([
            'nama_pasien' => ['required', 'string', 'max:100'],
            'tmp_lahir' => ['nullable', 'string', 'max:50'],
            'tgl_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'alamat' => ['required', 'string'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'agama' => ['nullable', 'string', 'max:30'],
            'pend_terakhir' => ['nullable', 'string', 'max:50'],
            'pekerjaan' => ['nullable', 'string', 'max:50'],
            'nama_pj_pasien' => ['nullable', 'string', 'max:100'],
            'hub_pj_pasien' => ['nullable', 'string', 'max:50'],
            'pekerjaan_pj' => ['nullable', 'string', 'max:50'],
            'no_pj' => ['nullable', 'string', 'max:20'],
        ]);

        $pasien->update($validated);

        return redirect()->route('front-office.pasien.index')
            ->with('success', 'Data pasien ' . $pasien->nama_pasien . ' berhasil diperbarui.');
    }

    public function pasienDestroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $nama = $pasien->nama_pasien;
        $pasien->delete();

        return redirect()->route('front-office.pasien.index')
            ->with('success', 'Data pasien ' . $nama . ' berhasil dihapus.');
    }

    // ==========================================
    // 2. MANAJEMEN PASIEN RAWAT JALAN (PRJ)
    // ==========================================
    public function prjIndex(Request $request)
    {
        $search = $request->query('search');

        $rawatJalans = RawatJalan::with(['pasien', 'dokter'])
            ->when($search, function ($query, $search) {
                $query->whereHas('pasien', function ($q) use ($search) {
                    $q->where('nama_pasien', 'like', "%{$search}%")
                        ->orWhere('no_rekam_medis', 'like', "%{$search}%");
                })->orWhere('departemen', 'like', "%{$search}%")
                  ->orWhere('keluhan', 'like', "%{$search}%");
            })
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        $pasiens = Pasien::orderBy('nama_pasien')->get();
        $dokters = Dokter::orderBy('nama_dokter')->get();
        $tarifs = Tarif::rawatJalan()->get();

        $totalPasien = Pasien::count();
        $totalPRJ = RawatJalan::count();
        $totalPRI = RawatInap::count();

        return view('front-office.prj.index', compact('rawatJalans', 'pasiens', 'dokters', 'tarifs', 'search', 'totalPasien', 'totalPRJ', 'totalPRI'));
    }

    public function prjStore(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => ['required', 'exists:pasiens,id'],
            'departemen' => ['required', 'string'],
            'keluhan' => ['required', 'string'],
            'dokter_id' => ['nullable', 'exists:dokters,id'],
            'bayar' => ['nullable', 'numeric', 'min:0'],
        ]);

        // Ambil tarif departemen
        $tarif = Tarif::rawatJalan()->where('departemen', $validated['departemen'])->value('tarif') ?? 0;

        RawatJalan::create([
            'pasien_id' => $validated['pasien_id'],
            'dokter_id' => $validated['dokter_id'] ?? null,
            'departemen' => $validated['departemen'],
            'tanggal' => now(),
            'keluhan' => $validated['keluhan'],
            'biaya' => $tarif,
            'bayar' => $validated['bayar'] ?? 0,
            'status_periksa' => 'menunggu',
        ]);

        return redirect()->route('front-office.prj.index')
            ->with('success', 'Pendaftaran Pasien Rawat Jalan berhasil dibuat.');
    }

    public function prjUpdate(Request $request, $id)
    {
        $prj = RawatJalan::findOrFail($id);

        $validated = $request->validate([
            'keluhan' => ['required', 'string'],
            'bayar' => ['required', 'numeric', 'min:0'],
            'tindakan' => ['nullable', 'string'],
        ]);

        $prj->update($validated);

        return redirect()->route('front-office.prj.index')
            ->with('success', 'Data Rawat Jalan No. ' . $prj->id . ' berhasil diperbarui.');
    }

    public function prjDestroy($id)
    {
        $prj = RawatJalan::findOrFail($id);
        $prj->delete();

        return redirect()->route('front-office.prj.index')
            ->with('success', 'Data Rawat Jalan berhasil dihapus.');
    }

    // ==========================================
    // 3. MANAJEMEN PASIEN RAWAT INAP (PRI)
    // ==========================================
    public function priIndex(Request $request)
    {
        $search = $request->query('search');

        $rawatInaps = RawatInap::with(['pasien', 'tarif'])
            ->when($search, function ($query, $search) {
                $query->whereHas('pasien', function ($q) use ($search) {
                    $q->where('nama_pasien', 'like', "%{$search}%");
                })->orWhere('id_ruang', 'like', "%{$search}%");
            })
            ->latest('tanggal_checkin')
            ->paginate(10)
            ->withQueryString();

        $pasiens = Pasien::orderBy('nama_pasien')->get();
        $tarifs = Tarif::rawatInap()->get();

        $totalPasien = Pasien::count();
        $totalPRJ = RawatJalan::count();
        $totalPRI = RawatInap::count();

        return view('front-office.pri.index', compact('rawatInaps', 'pasiens', 'tarifs', 'search', 'totalPasien', 'totalPRJ', 'totalPRI'));
    }

    public function priStore(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => ['required', 'exists:pasiens,id'],
            'tarif_id' => ['required', 'exists:tarifs,id'],
            'id_ruang' => ['required', 'string', 'max:20'],
            'tanggal_checkin' => ['required', 'date'],
            'diagnosa' => ['nullable', 'string'],
            'bayar' => ['nullable', 'numeric', 'min:0'],
        ]);

        $tarif = Tarif::findOrFail($validated['tarif_id']);

        RawatInap::create([
            'pasien_id' => $validated['pasien_id'],
            'tarif_id' => $tarif->id,
            'id_ruang' => $validated['id_ruang'],
            'tanggal_checkin' => $validated['tanggal_checkin'],
            'tanggal_checkout' => null,
            'hari_menginap' => 0,
            'diagnosa' => $validated['diagnosa'] ?? null,
            'biaya' => $tarif->tarif, // Biaya awal 1 hari
            'bayar' => $validated['bayar'] ?? 0,
            'status' => 'dirawat',
        ]);

        return redirect()->route('front-office.pri.index')
            ->with('success', 'Pendaftaran Rawat Inap kamar ' . $validated['id_ruang'] . ' berhasil didaftarkan.');
    }

    public function priUpdate(Request $request, $id)
    {
        $pri = RawatInap::with('tarif')->findOrFail($id);

        $validated = $request->validate([
            'id_ruang' => ['required', 'string'],
            'tanggal_checkin' => ['required', 'date'],
            'tanggal_checkout' => ['nullable', 'date', 'after_or_equal:tanggal_checkin'],
            'diagnosa' => ['nullable', 'string'],
            'bayar' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:dirawat,selesai'],
        ]);

        if (!empty($validated['tanggal_checkout'])) {
            $checkin = Carbon::parse($validated['tanggal_checkin']);
            $checkout = Carbon::parse($validated['tanggal_checkout']);
            $days = max(1, $checkin->diffInDays($checkout));
            $validated['hari_menginap'] = $days;

            $tarifPerHari = $pri->tarif ? $pri->tarif->tarif : ($pri->biaya / max(1, $pri->hari_menginap));
            $validated['biaya'] = $days * $tarifPerHari;
        }

        $pri->update($validated);

        return redirect()->route('front-office.pri.index')
            ->with('success', 'Data Rawat Inap Pasien ' . $pri->pasien->nama_pasien . ' berhasil diperbarui.');
    }

    public function priDestroy($id)
    {
        $pri = RawatInap::findOrFail($id);
        $pri->delete();

        return redirect()->route('front-office.pri.index')
            ->with('success', 'Data Rawat Inap berhasil dihapus.');
    }

    // ==========================================
    // 4. MASTER TARIF
    // ==========================================
    public function tarifIndex()
    {
        $tarifRJ = Tarif::rawatJalan()->get();
        $tarifRI = Tarif::rawatInap()->get();

        $totalPasien = Pasien::count();
        $totalPRJ = RawatJalan::count();
        $totalPRI = RawatInap::count();

        return view('front-office.tarif.index', compact('tarifRJ', 'tarifRI', 'totalPasien', 'totalPRJ', 'totalPRI'));
    }
}
