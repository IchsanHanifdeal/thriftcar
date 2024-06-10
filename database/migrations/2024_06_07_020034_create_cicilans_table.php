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
        Schema::create('cicilan', function (Blueprint $table) {
            $table->id('id_cicilan');
            $table->unsignedBigInteger('id_customer');
            $table->foreign('id_customer')->references('id_customer')->on('customer')->onDelete('cascade');
            $table->unsignedBigInteger('id_penjualan');
            $table->foreign('id_penjualan')->references('id_penjualan')->on('penjualan')->onDelete('cascade');
            $table->enum('tenor', ['3', '6', '9', '12', '24', '36']);
            $table->date('jatuh_tempo');
            $table->date('tanggal_pembayaran')->nullable();
            $table->string('jumlah_cicilan');
            $table->string('jumlah_pembayaran')->nullable();
            $table->enum('status_cicilan', ['dibayar', 'belum lunas', 'menunggu validasi'])->default('belum lunas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cicilan');
    }
};
