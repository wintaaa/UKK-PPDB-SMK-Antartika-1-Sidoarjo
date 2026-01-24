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
        Schema::table('pendaftar', function (Blueprint $table) {
            // Kolom untuk cicilan
            $table->decimal('biaya_jurusan', 15, 2)->default(0)->after('biaya_pendaftaran')->comment('Biaya pendaftaran jurusan');
            $table->decimal('total_terbayar', 15, 2)->default(0)->after('biaya_jurusan')->comment('Total yang sudah dibayar');
            $table->decimal('sisa_pembayaran', 15, 2)->default(0)->after('total_terbayar')->comment('Sisa yang harus dibayar');
            $table->integer('jumlah_cicilan', false, true)->default(1)->after('sisa_pembayaran')->comment('Jumlah cicilan yang dilakukan');
            $table->boolean('bisa_ikut_seleksi')->default(false)->after('jumlah_cicilan')->comment('Apakah boleh ikut seleksi (minimal bayar DP)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->dropColumn(['biaya_jurusan', 'total_terbayar', 'sisa_pembayaran', 'jumlah_cicilan', 'bisa_ikut_seleksi']);
        });
    }
};
