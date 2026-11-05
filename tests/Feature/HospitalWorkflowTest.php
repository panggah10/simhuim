<?php

namespace Tests\Feature;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\RawatJalan;
use App\Models\Resep;
use App\Models\User;
use Tests\TestCase;

class HospitalWorkflowTest extends TestCase
{
    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('SIMHUIM');
    }

    public function test_front_office_can_login_and_access_patient_index(): void
    {
        $user = User::where('username', 'admin')->first();

        $response = $this->actingAs($user)->get('/front-office/pasien');
        $response->assertStatus(200);
        $response->assertSee('Manajemen Data Pasien');
    }

    public function test_front_office_can_register_new_patient(): void
    {
        $user = User::where('username', 'admin')->first();

        $response = $this->actingAs($user)->post('/front-office/pasien', [
            'nama_pasien' => 'Pasien Uji Coba',
            'tmp_lahir' => 'Yogyakarta',
            'tgl_lahir' => '1995-05-15',
            'jenis_kelamin' => 'L',
            'alamat' => 'Jl. Kaliurang Km 10',
            'no_telepon' => '08123456789',
            'agama' => 'Islam',
            'pekerjaan' => 'Software Engineer',
        ]);

        $response->assertRedirect('/front-office/pasien');
        $this->assertDatabaseHas('pasiens', [
            'nama_pasien' => 'Pasien Uji Coba',
        ]);
    }

    public function test_departemen_can_access_queue(): void
    {
        $user = User::where('username', 'umum')->first();

        $response = $this->actingAs($user)->get('/departemen/pasien');
        $response->assertStatus(200);
        $response->assertSee('POLIKLINIK UMUM');
    }

    public function test_dokter_can_access_consultation_desk(): void
    {
        $user = User::where('username', 'irsyad')->first();

        $response = $this->actingAs($user)->get('/dokter/pasien');
        $response->assertStatus(200);
        $response->assertSee('Meja Pemeriksaan Dokter');
    }

    public function test_dokter_can_print_pdf_prescription(): void
    {
        $user = User::where('username', 'irsyad')->first();
        $resep = Resep::first();

        $response = $this->actingAs($user)->get('/dokter/resep/' . $resep->id . '/cetak');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }
}
