<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mobil', function (Blueprint $table) {
            $table->id('id_mobil');
            $table->string('gambar');
            $table->string('nama_mobil');
            $table->string('tipe_mobil');
            $table->string('merk_mobil');
            $table->enum('warna', ['merah', 'hitam', 'putih']);
            $table->enum('transmisi', ['manual', 'matic']);
            $table->string('stok');
            $table->integer('harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobils');
    }
};
