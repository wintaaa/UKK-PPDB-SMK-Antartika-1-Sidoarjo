<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftar;
use PDF;

class FormulirController extends Controller
{
    public function cetak()
    {
        // Generate nomor formulir unik, contoh: PPDB-2025-001
        $currentYear = date('Y');
        
        // Ambil pendaftar terakhir dari tahun ini untuk mendapatkan ID terakhir
        $lastPendaftar = Pendaftar::whereYear('created_at', $currentYear)->orderBy('id', 'desc')->first();
        
        // Tentukan nomor urut berikutnya. Jika tidak ada pendaftar tahun ini, mulai dari 1.
        $newPendaftarNumber = $lastPendaftar ? $lastPendaftar->id + 1 : 1;
        $no_formulir = 'PPDB-' . $currentYear . '-' . str_pad($newPendaftarNumber, 3, '0', STR_PAD_LEFT);

        // Siapkan data untuk disimpan
        $pendaftar = Pendaftar::create([
            'no_formulir' => $no_formulir,
            'tanggal_pendaftaran' => now(), // Laravel akan otomatis format ini
            'status_formulir' => 'keluar'
        ]);

        // Data yang akan dikirim ke view cetak_formulir
        $data = [
            'tanggal_pendaftaran' => now()->format('d F Y'),
            'no_formulir' => $no_formulir,
        ];

        // Generate PDF
        $pdf = PDF::loadView('cetak_formulir', $data);

        // Download PDF
        return $pdf->download('formulir-' . $no_formulir . '.pdf');
    }
}