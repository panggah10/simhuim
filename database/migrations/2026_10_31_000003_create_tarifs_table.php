<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tarifs', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', ['rawat_jalan', 'rawat_inap']);
            $table->string('kode', 20)->nullable();
            // Rawat Inap specific
            $table->string('perawatan', 50)->nullable();
            $table->string('pelayanan', 60)->nullable();
            $table->string('tipe_kamar', 50)->nullable();
            $table->integer('kapasitas')->default(1);
            // Rawat Jalan specific
            $table->string('departemen', 50)->nullable();
            // Price
            $table->integer('tarif')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarifs');
    }
};
