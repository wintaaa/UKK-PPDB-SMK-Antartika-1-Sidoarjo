<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;

    protected $table = 'pendaftar';

    protected $fillable = [
        'no_formulir',
        'email',
        'tanggal_pendaftaran',
        'status_formulir',
        'status_validasi',
        'status_pembayaran',
        'status_refund',
        'biaya_pendaftaran',
        'biaya_jurusan',
        'total_terbayar',
        'sisa_pembayaran',
        'jumlah_cicilan',
        'bisa_ikut_seleksi',
        'tanggal_pembayaran',
    ];

    protected $casts = [
        'biaya_pendaftaran' => 'integer',
        'biaya_jurusan' => 'integer',
        'total_terbayar' => 'integer',
        'sisa_pembayaran' => 'integer',
        'jumlah_cicilan' => 'integer',
        'bisa_ikut_seleksi' => 'boolean',
    ];

    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    public function dataOrangTua()
    {
        return $this->hasOne(DataOrangTua::class);
    }

    public function dataWali()
    {
        return $this->hasOne(DataWali::class);
    }

    /**
     * Relationship ke CicilanPembayaran
     */
    public function cicilanPembayaran()
    {
        return $this->hasMany(CicilanPembayaran::class);
    }

    /**
     * Hitung total yang sudah dibayar (hanya cicilan dengan status approved)
     */
    public function calculateTotalTerbayar()
    {
        return (int)$this->cicilanPembayaran()
            ->where('status', 'approved')
            ->sum('jumlah_cicilan') ?? 0;
    }

    /**
     * Hitung sisa pembayaran
     * Sisa = Biaya Jurusan - Total Terbayar (hanya yang approved)
     */
    public function calculateSisaPembayaran()
    {
        $totalTerbayar = $this->calculateTotalTerbayar();
        $sisa = (int)$this->biaya_jurusan - $totalTerbayar;
        return max(0, $sisa);
    }

    /**
     * Cek apakah sudah lunas
     */
    public function isSudahLunas()
    {
        return $this->calculateTotalTerbayar() >= (int)$this->biaya_jurusan;
    }

    /**
     * Cek apakah bisa ikut seleksi (minimal bayar DP 50%)
     */
    public function canJoinSelection()
    {
        $minimalDP = $this->biaya_jurusan * 0.5; // 50% dari biaya
        return $this->total_terbayar >= $minimalDP;
    }

    /**
     * Get persentase pembayaran
     * Contoh: Jika biaya 300.000 dan sudah bayar 150.000, maka persentasenya 50%
     */
    public function getPersentasePembayaran()
    {
        $biaya = (int)$this->biaya_jurusan;
        if ($biaya == 0) return 0;
        $totalTerbayar = $this->calculateTotalTerbayar();
        $persentase = ($totalTerbayar / $biaya) * 100;
        return min(100, round($persentase, 2));
    }
}
