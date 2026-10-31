<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rawat_inaps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->cascadeOnDelete();
            $table->foreignId('tarif_id')->nullable()->constrained('tarifs')->nullOnDelete();
            $table->string('id_ruang', 20); // Kamar / Bed ID or Number
            $table->date('tanggal_checkin');
            $table->date('tanggal_checkout')->nullable();
            $table->integer('hari_menginap')->default(0);
            $table->text('diagnosa')->nullable();
            $table->integer('biaya')->default(0);
            $table->integer('bayar')->default(0);
            $table->string('status')->default('dirawat'); // dirawat, selesai
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rawat_inaps');
    }
};
