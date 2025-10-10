<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftar', function (Blueprint $table) {
            $table->id();
            $table->string('no_formulir')->unique();
            $table->date('tanggal_pendaftaran');
            $table->string('status_formulir')->default('keluar'); // keluar, kembali
            $table->string('status_validasi')->default('belum_lengkap'); // lolos_validasi, belum_lengkap
            $table->string('status_pembayaran')->default('belum_lunas'); // lunas, belum_lunas
            $table->string('status_refund')->default('belum_diajukan'); // diajukan, diproses, selesai
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftar');
    }
};