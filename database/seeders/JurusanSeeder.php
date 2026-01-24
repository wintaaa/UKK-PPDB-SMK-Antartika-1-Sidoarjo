<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $jurusanData = [
            ['nama_jurusan' => 'Teknik Pemesinan', 'biaya_pendaftaran' => 300000],
            ['nama_jurusan' => 'Teknik Kendaraan Ringan', 'biaya_pendaftaran' => 300000],
            ['nama_jurusan' => 'Rekayasa Perangkat Lunak', 'biaya_pendaftaran' => 350000],
            ['nama_jurusan' => 'Teknik Instalasi Tenaga Listrik', 'biaya_pendaftaran' => 300000],
            ['nama_jurusan' => 'Teknik Elektronika Industri', 'biaya_pendaftaran' => 300000],
        ];

        foreach ($jurusanData as $jurusan) {
            Jurusan::updateOrCreate(
                ['nama_jurusan' => $jurusan['nama_jurusan']],
                [
                    'kapasitas_slot' => 36,
                    'terdaftar' => 0,
                    'biaya_pendaftaran' => $jurusan['biaya_pendaftaran'],
                ]
            );
        }
    }
}
