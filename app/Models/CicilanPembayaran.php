<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CicilanPembayaran extends Model
{
    use HasFactory;

    protected $table = 'cicilan_pembayaran';

    protected $fillable = [
        'pendaftar_id',
        'jumlah_cicilan',
        'tanggal_pembayaran',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'datetime',
    ];

    /**
     * Relationship ke Pendaftar
     */
    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }
}
