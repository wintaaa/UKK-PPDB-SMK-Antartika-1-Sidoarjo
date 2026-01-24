<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';

    protected $fillable = [
        'nama_jurusan',
        'kapasitas_slot',
        'terdaftar',
        'biaya_pendaftaran',
    ];

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    /**
     * Cek apakah jurusan masih memiliki slot tersedia
     */
    public function hasAvailableSlot(): bool
    {
        return $this->terdaftar < $this->kapasitas_slot;
    }

    /**
     * Dapatkan jumlah slot yang tersisa
     */
    public function getAvailableSlots(): int
    {
        return $this->kapasitas_slot - $this->terdaftar;
    }
}
