<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\RawatJalan;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index(Request $request)
    {
        $departemenNama = auth()->user()->grup;

        $search = $request->query('search');

        $rawatJalans = RawatJalan::with(['pasien', 'dokter'])
            ->where('departemen', $departemenNama)
            ->when($search, function ($query, $search) {
                $query->whereHas('pasien', function ($q) use ($search) {
                    $q->where('nama_pasien', 'like', "%{$search}%")
                        ->orWhere('no_rekam_medis', 'like', "%{$search}%");
                })->orWhere('keluhan', 'like', "%{$search}%");
            })
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        $dokters = Dokter::where('departemen', $departemenNama)->get();

        $totalPasienDept = RawatJalan::where('departemen', $departemenNama)->count();
        $totalDokterDept = Dokter::where('departemen', $departemenNama)->count();

        return view('departemen.pasien.index', compact(
            'rawatJalans',
            'dokters',
            'departemenNama',
            'totalPasienDept',
            'totalDokterDept',
            'search'
        ));
    }

    public function assignDokter(Request $request, $id)
    {
        $departemenNama = auth()->user()->grup;
        $prj = RawatJalan::where('departemen', $departemenNama)->findOrFail($id);

        $validated = $request->validate([
            'dokter_id' => ['required', 'exists:dokters,id'],
        ]);

        $prj->update([
            'dokter_id' => $validated['dokter_id'],
        ]);

        return redirect()->route('departemen.pasien.index')
            ->with('success', 'Dokter pemeriksa berhasil ditugaskan untuk pasien ' . $prj->pasien->nama_pasien);
    }

    public function jadwalDokter()
    {
        $departemenNama = auth()->user()->grup;
        $dokters = Dokter::where('departemen', $departemenNama)->get();

        $totalPasienDept = RawatJalan::where('departemen', $departemenNama)->count();
        $totalDokterDept = Dokter::where('departemen', $departemenNama)->count();

        return view('departemen.dokter.jadwal', compact(
            'dokters',
            'departemenNama',
            'totalPasienDept',
            'totalDokterDept'
        ));
    }
}
