<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reseps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->cascadeOnDelete();
            $table->foreignId('dokter_id')->constrained('dokters')->cascadeOnDelete();
            $table->foreignId('rawat_jalan_id')->nullable()->constrained('rawat_jalans')->nullOnDelete();
            $table->string('nama_resep');
            $table->text('rincian_resep');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reseps');
    }
};
