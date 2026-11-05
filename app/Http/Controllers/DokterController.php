<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\RawatJalan;
use App\Models\Resep;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    private function getDokter()
    {
        $user = auth()->user();
        return Dokter::where('user_id', $user->id)
            ->orWhere('nama_dokter', $user->grup)
            ->first();
    }

    public function index(Request $request)
    {
        $dokter = $this->getDokter();

        if (!$dokter) {
            abort(403, 'Profil Dokter Anda belum terdaftar.');
        }

        $search = $request->query('search');

        $rawatJalans = RawatJalan::with('pasien')
            ->where('dokter_id', $dokter->id)
            ->when($search, function ($query, $search) {
                $query->whereHas('pasien', function ($q) use ($search) {
                    $q->where('nama_pasien', 'like', "%{$search}%")
                        ->orWhere('no_rekam_medis', 'like', "%{$search}%");
                })->orWhere('keluhan', 'like', "%{$search}%")
                  ->orWhere('diagnosa', 'like', "%{$search}%");
            })
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        $totalPasienDokter = RawatJalan::where('dokter_id', $dokter->id)->count();
        $totalResepDokter = Resep::where('dokter_id', $dokter->id)->count();

        return view('dokter.pasien.index', compact(
            'rawatJalans',
            'dokter',
            'totalPasienDokter',
            'totalResepDokter',
            'search'
        ));
    }

    public function diagnosa(Request $request, $id)
    {
        $dokter = $this->getDokter();
        $prj = RawatJalan::where('dokter_id', $dokter->id)->findOrFail($id);

        $validated = $request->validate([
            'diagnosa' => ['required', 'string'],
            'tindakan' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['status_periksa'] = 'selesai';

        $prj->update($validated);

        return redirect()->route('dokter.pasien.index')
            ->with('success', 'Diagnosa dan tindakan untuk pasien ' . $prj->pasien->nama_pasien . ' berhasil disimpan.');
    }

    // ==========================================
    // E-RESEP DOKTER
    // ==========================================
    public function resepIndex(Request $request)
    {
        $dokter = $this->getDokter();

        $search = $request->query('search');

        $reseps = Resep::with(['pasien', 'rawatJalan'])
            ->where('dokter_id', $dokter->id)
            ->when($search, function ($query, $search) {
                $query->whereHas('pasien', function ($q) use ($search) {
                    $q->where('nama_pasien', 'like', "%{$search}%")
                        ->orWhere('no_rekam_medis', 'like', "%{$search}%");
                })->orWhere('nama_resep', 'like', "%{$search}%")
                  ->orWhere('rincian_resep', 'like', "%{$search}%");
            })
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        // Daftar pasien yang pernah ditangani dokter ini
        $pasiens = Pasien::whereHas('rawatJalans', function ($q) use ($dokter) {
            $q->where('dokter_id', $dokter->id);
        })->get();

        $totalPasienDokter = RawatJalan::where('dokter_id', $dokter->id)->count();
        $totalResepDokter = Resep::where('dokter_id', $dokter->id)->count();

        return view('dokter.resep.index', compact(
            'reseps',
            'dokter',
            'pasiens',
            'totalPasienDokter',
            'totalResepDokter',
            'search'
        ));
    }

    public function resepStore(Request $request)
    {
        $dokter = $this->getDokter();

        $validated = $request->validate([
            'pasien_id' => ['required', 'exists:pasiens,id'],
            'nama_resep' => ['required', 'string', 'max:100'],
            'rincian_resep' => ['required', 'string'],
            'tanggal' => ['required', 'date'],
        ]);

        // Hubungkan ke rawat jalan terakhir jika ada
        $lastRJ = RawatJalan::where('pasien_id', $validated['pasien_id'])
            ->where('dokter_id', $dokter->id)
            ->latest('tanggal')
            ->first();

        Resep::create([
            'pasien_id' => $validated['pasien_id'],
            'dokter_id' => $dokter->id,
            'rawat_jalan_id' => $lastRJ?->id,
            'nama_resep' => $validated['nama_resep'],
            'rincian_resep' => $validated['rincian_resep'],
            'tanggal' => $validated['tanggal'],
        ]);

        return redirect()->route('dokter.resep.index')
            ->with('success', 'Resep obat berhasil diterbitkan.');
    }

    public function resepUpdate(Request $request, $id)
    {
        $dokter = $this->getDokter();
        $resep = Resep::where('dokter_id', $dokter->id)->findOrFail($id);

        $validated = $request->validate([
            'nama_resep' => ['required', 'string', 'max:100'],
            'rincian_resep' => ['required', 'string'],
            'tanggal' => ['required', 'date'],
        ]);

        $resep->update($validated);

        return redirect()->route('dokter.resep.index')
            ->with('success', 'Resep obat berhasil diperbarui.');
    }

    public function resepDestroy($id)
    {
        $dokter = $this->getDokter();
        $resep = Resep::where('dokter_id', $dokter->id)->findOrFail($id);
        $resep->delete();

        return redirect()->route('dokter.resep.index')
            ->with('success', 'Resep obat berhasil dihapus.');
    }

    public function cetakResep($id)
    {
        $dokter = $this->getDokter();
        $resep = Resep::with(['pasien', 'dokter'])->where('dokter_id', $dokter->id)->findOrFail($id);

        $pdf = Pdf::loadView('dokter.resep.pdf', compact('resep'))
            ->setPaper('a5', 'portrait');

        return $pdf->stream('Resep-' . $resep->id . '-' . $resep->pasien->nama_pasien . '.pdf');
    }
}
