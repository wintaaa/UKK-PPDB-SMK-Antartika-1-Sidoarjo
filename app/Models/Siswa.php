<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'pendaftar_id',
        'nama_siswa',
        'jenis_kelamin',
        'nisn',
        'nik',
        'npsn_sekolah_asal',
        'nama_sekolah_asal',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'dusun',
        'rt_rw',
        'kecamatan',
        'desa_kelurahan',
        'kabupaten_kota',
        'alat_transportasi',
        'anak_ke',
        'jumlah_saudara',
        'jenis_tinggal',
        'no_telp_rumah',
        'no_hp_wa',
        'tinggi_badan',
        'berat_badan',
        'jarak_tempuh',
        'waktu_tempuh',
        'pilihan_jurusan',
        'ijazah_smp',
        'kk',
        'akta_kelahiran',
        'foto',
    ];
    
    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'pilihan_jurusan', 'nama_jurusan');
    }
}