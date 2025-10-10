<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftar_id')->constrained('pendaftar')->onDelete('cascade');
            $table->string('nama_siswa');
            $table->string('jenis_kelamin');
            $table->string('nisn');
            $table->string('nik');
            $table->string('npsn_sekolah_asal');
            $table->string('nama_sekolah_asal');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->string('alamat');
            $table->string('dusun')->nullable();
            $table->string('rt_rw')->nullable();
            $table->string('kecamatan');
            $table->string('desa_kelurahan');
            $table->string('kabupaten_kota');
            $table->string('alat_transportasi');
            $table->integer('anak_ke');
            $table->integer('jumlah_saudara');
            $table->string('jenis_tinggal');
            $table->string('no_telp_rumah')->nullable();
            $table->string('no_hp_wa');
            $table->float('tinggi_badan')->nullable();
            $table->float('berat_badan')->nullable();
            $table->float('jarak_tempuh')->nullable();
            $table->integer('waktu_tempuh')->nullable();
            $table->string('pilihan_jurusan');
            $table->boolean('ijazah_smp')->default(false);
            $table->boolean('kk')->default(false);
            $table->boolean('akta_kelahiran')->default(false);
            $table->boolean('foto')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};