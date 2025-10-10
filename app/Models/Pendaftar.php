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
        'tanggal_pendaftaran', // Tambahkan ini
        'status_formulir',
        'status_validasi',
        'status_pembayaran',
        'status_refund',
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
}