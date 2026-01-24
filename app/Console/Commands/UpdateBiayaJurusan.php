<?php

namespace App\Console\Commands;

use App\Models\Pendaftar;
use App\Models\Siswa;
use App\Models\Jurusan;
use Illuminate\Console\Command;

class UpdateBiayaJurusan extends Command
{
    protected $signature = 'update:biaya-jurusan';
    protected $description = 'Update biaya jurusan untuk pendaftar yang belum memiliki biaya_jurusan';

    public function handle()
    {
        $pendaftars = Pendaftar::where('biaya_jurusan', '=', 0)
            ->orWhereNull('biaya_jurusan')
            ->get();

        if ($pendaftars->isEmpty()) {
            $this->info('Semua pendaftar sudah memiliki biaya jurusan.');
            return;
        }

        foreach ($pendaftars as $pendaftar) {
            $siswa = $pendaftar->siswa;
            if (!$siswa) continue;

            // Cari jurusan berdasarkan nama jurusan
            $jurusan = Jurusan::where('nama_jurusan', $siswa->pilihan_jurusan)->first();
            
            if ($jurusan) {
                $pendaftar->update([
                    'biaya_jurusan' => $jurusan->biaya_pendaftaran,
                    'sisa_pembayaran' => $jurusan->biaya_pendaftaran - $pendaftar->total_terbayar,
                ]);
                $this->info("Updated: {$pendaftar->no_formulir} - {$siswa->nama_siswa} - Rp " . number_format($jurusan->biaya_pendaftaran, 0, ',', '.'));
            } else {
                $this->warn("Jurusan tidak ditemukan: {$siswa->pilihan_jurusan} untuk pendaftar {$pendaftar->no_formulir}");
            }
        }

        $this->info('Update biaya jurusan selesai!');
    }
}
