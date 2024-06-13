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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bahan_masakan_id');
            $table->date('tanggal_transaksi');
            $table->integer('barang_masuk')->default(0);
            $table->integer('barang_keluar')->default(0);
            $table->integer('barang_sisa')->default(0);
            $table->timestamps();

            $table->foreign('bahan_masakan_id')->references('id')->on('bahan_masakan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
