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
            // Ubah dari decimal ke bigInteger untuk menghindari floating-point precision issues
            $table->bigInteger('biaya_jurusan')->default(0)->change();
            $table->bigInteger('total_terbayar')->default(0)->change();
            $table->bigInteger('sisa_pembayaran')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            // Revert ke decimal jika perlu rollback
            $table->decimal('biaya_jurusan', 15, 2)->default(0)->change();
            $table->decimal('total_terbayar', 15, 2)->default(0)->change();
            $table->decimal('sisa_pembayaran', 15, 2)->default(0)->change();
        });
    }
};
