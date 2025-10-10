<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataWali extends Model
{
    use HasFactory;

    protected $table = 'data_wali';

    protected $fillable = [
        'pendaftar_id',
        'nama_wali',
        'tahun_lahir_wali',
        'nik_wali',
        'pendidikan_wali',
        'pekerjaan_wali',
        'penghasilan_wali',
    ];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }
}