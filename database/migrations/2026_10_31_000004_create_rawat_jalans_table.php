<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rawat_jalans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->cascadeOnDelete();
            $table->foreignId('dokter_id')->nullable()->constrained('dokters')->nullOnDelete();
            $table->string('departemen', 50);
            $table->dateTime('tanggal');
            $table->text('keluhan');
            $table->text('diagnosa')->nullable();
            $table->string('tindakan')->nullable();
            $table->integer('biaya')->default(0);
            $table->integer('bayar')->default(0);
            $table->string('status_periksa')->default('menunggu'); // menunggu, diperiksa, selesai
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rawat_jalans');
    }
};
