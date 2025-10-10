<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataOrangTua extends Model
{
    use HasFactory;
    
    protected $table = 'data_orang_tua';

    protected $fillable = [
        'pendaftar_id',
        'nama_ayah',
        'tahun_lahir_ayah',
        'nik_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'nama_ibu',
        'tahun_lahir_ibu',
        'nik_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
    ];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }
}