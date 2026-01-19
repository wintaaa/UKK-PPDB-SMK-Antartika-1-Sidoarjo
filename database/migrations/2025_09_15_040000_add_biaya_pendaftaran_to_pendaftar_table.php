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
            $table->decimal('biaya_pendaftaran', 15, 2)->default(0)->after('status_refund');
            $table->timestamp('tanggal_pembayaran')->nullable()->after('biaya_pendaftaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->dropColumn(['biaya_pendaftaran', 'tanggal_pembayaran']);
        });
    }
};
