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
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->double('omset', 15);
            $table->double('purchasing', 15);
            $table->double('tenaga_kerja', 15);
            $table->double('pln', 15);
            $table->double('akomodasi', 15);
            $table->double('sewa_alat', 15);
            $table->double('profit', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangans');
    }
};
