<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\RawatInap;
use App\Models\RawatJalan;
use App\Models\Resep;
use App\Models\Tarif;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Users
        // Admin Front Office
        $admin = User::create([
            'name' => 'Petugas Front Office',
            'username' => 'admin',
            'email' => 'admin@uim.ac.id',
            'password' => Hash::make('admin'),
            'role' => 'Front Office',
            'grup' => 'Front Office',
            'status' => true,
        ]);

        // Departemen Users
        $departemens = [
            ['username' => 'umum', 'name' => 'Poli Umum', 'grup' => 'Umum'],
            ['username' => 'gigi', 'name' => 'Poli Gigi', 'grup' => 'Gigi'],
            ['username' => 'anak', 'name' => 'Poli Anak', 'grup' => 'Anak'],
            ['username' => 'kandungan', 'name' => 'Poli Kandungan', 'grup' => 'Kandungan'],
            ['username' => 'tht', 'name' => 'Poli THT', 'grup' => 'THT'],
            ['username' => 'syaraf', 'name' => 'Poli Syaraf', 'grup' => 'Syaraf'],
            ['username' => 'kulitkelamin', 'name' => 'Poli Kulit & Kelamin', 'grup' => 'Kulit dan Kelamin'],
        ];

        foreach ($departemens as $dept) {
            User::create([
                'name' => $dept['name'],
                'username' => $dept['username'],
                'email' => $dept['username'] . '@uim.ac.id',
                'password' => Hash::make($dept['username']),
                'role' => 'Departemen',
                'grup' => $dept['grup'],
                'status' => true,
            ]);
        }

        // Dokter Users & Dokter Profile
        $dokterData = [
            ['username' => 'irsyad', 'name' => 'Irsyad Muhammad, dr', 'dept' => 'Umum', 'jadwal' => 'Senin - Kamis | 08.00 - 15.00'],
            ['username' => 'audy', 'name' => 'Pranata Audy, dr.SpB', 'dept' => 'Gigi', 'jadwal' => 'Senin - Kamis | 08.00 - 15.00'],
            ['username' => 'jaidi', 'name' => 'Jaidi, dr.SpA', 'dept' => 'Anak', 'jadwal' => 'Senin - Kamis | 08.00 - 15.00'],
            ['username' => 'tama', 'name' => 'Anugrah Pratama, dr.SpPD', 'dept' => 'Kandungan', 'jadwal' => 'Senin - Kamis | 08.00 - 15.00'],
            ['username' => 'dendi', 'name' => 'Dendi Abdul Rohim, H.dr.SpB', 'dept' => 'THT', 'jadwal' => 'Senin - Kamis | 08.00 - 15.00'],
            ['username' => 'aditya', 'name' => 'Kurniawan Aditya, dr.SpOG', 'dept' => 'Kandungan', 'jadwal' => 'Senin - Kamis | 08.00 - 15.00'],
            ['username' => 'arif', 'name' => 'Arifin Muhammad, dr.SpS.Mkes', 'dept' => 'Syaraf', 'jadwal' => 'Senin - Kamis | 08.00 - 15.00'],
            ['username' => 'gyats', 'name' => 'Gyats Haitsam, Hj.dr.SpKK', 'dept' => 'Kulit dan Kelamin', 'jadwal' => 'Senin - Kamis | 08.00 - 15.00'],
            ['username' => 'dono', 'name' => 'Dono Aditia, .dr.SpTHT', 'dept' => 'THT', 'jadwal' => 'Senin - Kamis | 08.00 - 15.00'],
            ['username' => 'zeffry', 'name' => 'Zeffry Irwanto, dr.SpM', 'dept' => 'Kulit dan Kelamin', 'jadwal' => 'Senin - Kamis | 08.00 - 15.00'],
            ['username' => 'gustian', 'name' => 'Gustian M, dr', 'dept' => 'Syaraf', 'jadwal' => 'Senin - Kamis | 08.00 - 15.00'],
            ['username' => 'septianti', 'name' => 'Septianti Amalia, S.PSi', 'dept' => 'Umum', 'jadwal' => 'Senin - Kamis | 08.00 - 15.00'],
            ['username' => 'setyaningsih', 'name' => 'Setyaningsih D, dr.SpA', 'dept' => 'Anak', 'jadwal' => 'Senin - Kamis | 08.00 - 15.00'],
            ['username' => 'bayu', 'name' => 'Bayu, H.dr.SpB', 'dept' => 'Umum', 'jadwal' => 'Senin - Kamis | 08.00 - 15.00'],
        ];

        foreach ($dokterData as $d) {
            $user = User::create([
                'name' => $d['name'],
                'username' => $d['username'],
                'email' => $d['username'] . '@uim.ac.id',
                'password' => Hash::make($d['username']),
                'role' => 'Dokter',
                'grup' => $d['name'],
                'status' => true,
            ]);

            Dokter::create([
                'user_id' => $user->id,
                'nama_dokter' => $d['name'],
                'departemen' => $d['dept'],
                'jadwal_praktik' => $d['jadwal'],
            ]);
        }

        // 2. Seed Master Tarif Rawat Jalan
        $tarifRJ = [
            ['departemen' => 'Umum', 'tarif' => 150000],
            ['departemen' => 'Gigi', 'tarif' => 160000],
            ['departemen' => 'Anak', 'tarif' => 180000],
            ['departemen' => 'Kandungan', 'tarif' => 200000],
            ['departemen' => 'THT', 'tarif' => 150000],
            ['departemen' => 'Syaraf', 'tarif' => 180000],
            ['departemen' => 'Kulit dan Kelamin', 'tarif' => 300000],
        ];

        foreach ($tarifRJ as $trj) {
            Tarif::create([
                'jenis' => 'rawat_jalan',
                'departemen' => $trj['departemen'],
                'tarif' => $trj['tarif'],
            ]);
        }

        // 3. Seed Master Tarif Rawat Inap
        $tarifRI = [
            ['perawatan' => 'Rawat Inap per hari', 'pelayanan' => 'Dokter Spesialis dan Umum', 'tipe_kamar' => 'Kelas VIP', 'tarif' => 375000, 'kapasitas' => 1],
            ['perawatan' => 'Rawat Inap per hari', 'pelayanan' => 'Dokter Spesialis dan Umum', 'tipe_kamar' => 'Kelas I', 'tarif' => 220000, 'kapasitas' => 2],
            ['perawatan' => 'Rawat Inap per hari', 'pelayanan' => 'Dokter Spesialis dan Umum', 'tipe_kamar' => 'Kelas II', 'tarif' => 153000, 'kapasitas' => 3],
            ['perawatan' => 'Rawat Inap per hari', 'pelayanan' => 'Dokter Spesialis dan Umum', 'tipe_kamar' => 'Kelas III', 'tarif' => 130000, 'kapasitas' => 6],
            ['perawatan' => 'Rawat Inap per hari', 'pelayanan' => 'Dokter Umum', 'tipe_kamar' => 'Kelas VIP', 'tarif' => 325000, 'kapasitas' => 1],
            ['perawatan' => 'Rawat Inap per hari', 'pelayanan' => 'Dokter Umum', 'tipe_kamar' => 'Kelas I', 'tarif' => 200000, 'kapasitas' => 2],
            ['perawatan' => 'Rawat Inap per hari', 'pelayanan' => 'Dokter Umum', 'tipe_kamar' => 'Kelas II', 'tarif' => 147000, 'kapasitas' => 3],
            ['perawatan' => 'Rawat Inap per hari', 'pelayanan' => 'Dokter Umum', 'tipe_kamar' => 'Kelas III', 'tarif' => 120000, 'kapasitas' => 6],
            ['perawatan' => 'Ruang ICU', 'pelayanan' => 'Dokter Spesialis dan Umum', 'tipe_kamar' => 'ICU Reguler', 'tarif' => 200000, 'kapasitas' => 2],
            ['perawatan' => 'Ruang ICU', 'pelayanan' => 'Instalasi Anestesi', 'tipe_kamar' => 'Kelas I', 'tarif' => 217000, 'kapasitas' => 2],
            ['perawatan' => 'Perinatologi', 'pelayanan' => 'Dokter Spesialis dan Umum', 'tipe_kamar' => 'Kelas VIP', 'tarif' => 225000, 'kapasitas' => 1],
            ['perawatan' => 'Perinatologi', 'pelayanan' => 'Persalinan Normal Dokter', 'tipe_kamar' => 'Kelas VIP', 'tarif' => 560000, 'kapasitas' => 1],
        ];

        foreach ($tarifRI as $tri) {
            Tarif::create([
                'jenis' => 'rawat_inap',
                'perawatan' => $tri['perawatan'],
                'pelayanan' => $tri['pelayanan'],
                'tipe_kamar' => $tri['tipe_kamar'],
                'tarif' => $tri['tarif'],
                'kapasitas' => $tri['kapasitas'],
            ]);
        }

        // 4. Seed Patients
        $patients = [
            [
                'no_rekam_medis' => 'RM-000001',
                'nama_pasien' => 'Muhammad Ilyas Firdaus',
                'alamat' => 'Sleman, D.I. Yogyakarta',
                'jenis_kelamin' => 'L',
                'no_telepon' => '081264162001',
                'agama' => 'Islam',
                'pend_terakhir' => 'S1',
                'pekerjaan' => 'Karyawan Swasta',
                'nama_pj_pasien' => 'Firdaus Senior',
                'hub_pj_pasien' => 'Orang Tua',
                'pekerjaan_pj' => 'PNS',
                'no_pj' => '081264162002',
            ],
            [
                'no_rekam_medis' => 'RM-000002',
                'nama_pasien' => 'Raffi Ahmad',
                'alamat' => 'Jonggol, Bogor',
                'jenis_kelamin' => 'L',
                'no_telepon' => '08126252153',
                'agama' => 'Islam',
                'pend_terakhir' => 'SMA',
                'pekerjaan' => 'Wiraswasta',
                'nama_pj_pasien' => 'Amy Qanita',
                'hub_pj_pasien' => 'Orang Tua',
                'pekerjaan_pj' => 'Ibu Rumah Tangga',
                'no_pj' => '08126252150',
            ],
            [
                'no_rekam_medis' => 'RM-000003',
                'nama_pasien' => 'Chelsea Islan',
                'alamat' => 'Kebayoran Baru, Jakarta Selatan',
                'jenis_kelamin' => 'P',
                'no_telepon' => '08241624299',
                'agama' => 'Katolik',
                'pend_terakhir' => 'S1',
                'pekerjaan' => 'Seniman',
                'nama_pj_pasien' => 'Rob Clinton',
                'hub_pj_pasien' => 'Suami',
                'pekerjaan_pj' => 'Pengusaha',
                'no_pj' => '08241624298',
            ],
            [
                'no_rekam_medis' => 'RM-000004',
                'nama_pasien' => 'Raisa Ardiana',
                'alamat' => 'Sukabumi, Jawa Barat',
                'jenis_kelamin' => 'P',
                'no_telepon' => '0212312415',
                'agama' => 'Islam',
                'pend_terakhir' => 'S1',
                'pekerjaan' => 'Musisi',
                'nama_pj_pasien' => 'Hamish Daud',
                'hub_pj_pasien' => 'Suami',
                'pekerjaan_pj' => 'Presenter',
                'no_pj' => '0212312410',
            ],
            [
                'no_rekam_medis' => 'RM-000005',
                'nama_pasien' => 'Ikhwan Pratama',
                'alamat' => 'Kaliurang Km 5, Yogyakarta',
                'jenis_kelamin' => 'L',
                'no_telepon' => '085943774442',
                'agama' => 'Islam',
                'pend_terakhir' => 'S1',
                'pekerjaan' => 'Mahasiswa',
                'nama_pj_pasien' => 'Budi Pratama',
                'hub_pj_pasien' => 'Ayah',
                'pekerjaan_pj' => 'Wiraswasta',
                'no_pj' => '085943774440',
            ],
        ];

        foreach ($patients as $p) {
            Pasien::create($p);
        }

        // 5. Sample Rawat Jalan
        $dokter1 = Dokter::first();
        $pasien1 = Pasien::first();
        $pasien2 = Pasien::find(2);

        $rj1 = RawatJalan::create([
            'pasien_id' => $pasien1->id,
            'dokter_id' => $dokter1->id,
            'departemen' => 'Umum',
            'tanggal' => now(),
            'keluhan' => 'Demam tinggi selama 3 hari disertai batuk kering dan sakit kepala',
            'diagnosa' => 'Febris Akut suspek Faringitis Viral',
            'tindakan' => 'Pemeriksaan Fisik & Pemberian Antipiretik',
            'biaya' => 150000,
            'bayar' => 150000,
            'status_periksa' => 'selesai',
        ]);

        RawatJalan::create([
            'pasien_id' => $pasien2->id,
            'dokter_id' => null, // Belum ditentukan oleh departemen
            'departemen' => 'Gigi',
            'tanggal' => now(),
            'keluhan' => 'Nyeri pada gigi geraham bawah kanan berdenyut sejak kemarin',
            'diagnosa' => null,
            'tindakan' => null,
            'biaya' => 160000,
            'bayar' => 160000,
            'status_periksa' => 'menunggu',
        ]);

        // 6. Sample Rawat Inap
        $tarifVIP = Tarif::where('tipe_kamar', 'Kelas VIP')->first();
        RawatInap::create([
            'pasien_id' => $pasien1->id,
            'tarif_id' => $tarifVIP?->id,
            'id_ruang' => 'VIP-101',
            'tanggal_checkin' => now()->subDays(3)->toDateString(),
            'tanggal_checkout' => now()->toDateString(),
            'hari_menginap' => 3,
            'diagnosa' => 'Dengue Fever grade 1 dengan observasi trombosit',
            'biaya' => 1125000,
            'bayar' => 1125000,
            'status' => 'selesai',
        ]);

        RawatInap::create([
            'pasien_id' => $pasien2->id,
            'tarif_id' => $tarifVIP?->id,
            'id_ruang' => '102',
            'tanggal_checkin' => now()->subDays(1)->toDateString(),
            'tanggal_checkout' => null,
            'hari_menginap' => 1,
            'diagnosa' => 'Gastroenteritis Akut Dehidrasi Sedang',
            'biaya' => 375000,
            'bayar' => 375000,
            'status' => 'dirawat',
        ]);

        // 7. Sample Resep
        Resep::create([
            'pasien_id' => $pasien1->id,
            'dokter_id' => $dokter1->id,
            'rawat_jalan_id' => $rj1->id,
            'nama_resep' => 'Resep Demam & Batuk',
            'rincian_resep' => "- Paracetamol 500mg 3x1 tablet sesudah makan (bila demam)\n- Cetirizine 10mg 1x1 tablet malam hari\n- Vitamin C 500mg 1x1 tablet pagi hari",
            'tanggal' => now()->toDateString(),
        ]);
    }
}
