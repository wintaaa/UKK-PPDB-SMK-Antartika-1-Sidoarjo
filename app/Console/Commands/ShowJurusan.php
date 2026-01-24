<?php

namespace App\Console\Commands;

use App\Models\Jurusan;
use Illuminate\Console\Command;

class ShowJurusan extends Command
{
    protected $signature = 'show:jurusan';
    protected $description = 'Tampilkan data jurusan dan harga pendaftaran';

    public function handle()
    {
        $jurusans = Jurusan::all();

        if ($jurusans->isEmpty()) {
            $this->error('Tidak ada data jurusan');
            return;
        }

        $headers = ['ID', 'Nama Jurusan', 'Kapasitas', 'Terdaftar', 'Biaya Pendaftaran'];
        $rows = [];

        foreach ($jurusans as $jurusan) {
            $rows[] = [
                $jurusan->id,
                $jurusan->nama_jurusan,
                $jurusan->kapasitas_slot,
                $jurusan->terdaftar,
                'Rp ' . number_format($jurusan->biaya_pendaftaran, 0, ',', '.'),
            ];
        }

        $this->table($headers, $rows);
    }
}
