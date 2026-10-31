<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('no_rekam_medis')->nullable()->unique();
            $table->string('nama_pasien');
            $table->string('tmp_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->default('L');
            $table->text('alamat');
            $table->string('no_telepon', 20)->nullable();
            $table->string('agama', 30)->nullable();
            $table->string('pend_terakhir', 50)->nullable();
            $table->string('pekerjaan', 50)->nullable();
            $table->string('nama_pj_pasien', 100)->nullable();
            $table->string('hub_pj_pasien', 50)->nullable();
            $table->string('pekerjaan_pj', 50)->nullable();
            $table->string('no_pj', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
