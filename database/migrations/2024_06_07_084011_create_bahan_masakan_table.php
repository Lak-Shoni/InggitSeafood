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
        Schema::create('bahan_masakan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->integer('barang_masuk');
            $table->integer('barang_keluar');
            $table->integer('barang_sisa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bahan_masakan');
    }
};
