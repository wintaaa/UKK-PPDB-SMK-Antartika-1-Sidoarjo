<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Import models
use App\Models\Pendaftar;
use App\Models\CicilanPembayaran;

// Query pendaftar ID 12
$pendaftar = Pendaftar::find(12);

if ($pendaftar) {
    echo "=== PENDAFTAR ID 12 ===\n";
    echo "Biaya Jurusan: Rp " . number_format($pendaftar->biaya_jurusan, 0, ',', '.') . "\n";
    echo "Total Terbayar (DB): Rp " . number_format($pendaftar->total_terbayar, 0, ',', '.') . "\n";
    echo "Sisa Pembayaran (DB): Rp " . number_format($pendaftar->sisa_pembayaran, 0, ',', '.') . "\n";
    echo "Status Pembayaran: " . $pendaftar->status_pembayaran . "\n";
    echo "\n";
    
    // Calculate from method
    $totalHitung = $pendaftar->calculateTotalTerbayar();
    $sisaHitung = $pendaftar->calculateSisaPembayaran();
    echo "=== CALCULATE FROM METHOD ===\n";
    echo "Total Terbayar (calculated): Rp " . number_format($totalHitung, 0, ',', '.') . "\n";
    echo "Sisa Pembayaran (calculated): Rp " . number_format($sisaHitung, 0, ',', '.') . "\n";
    echo "\n";
    
    // Show all cicilan
    echo "=== CICILAN DATA ===\n";
    $cicilan = CicilanPembayaran::where('pendaftar_id', 12)->orderBy('tanggal_pembayaran')->get();
    foreach ($cicilan as $c) {
        echo "ID: {$c->id}, Jumlah: Rp " . number_format($c->jumlah_cicilan, 0, ',', '.') . ", Status: {$c->status}, Tgl: {$c->tanggal_pembayaran}\n";
    }
    
    // Total approved only
    $totalApproved = CicilanPembayaran::where('pendaftar_id', 12)
        ->where('status', 'approved')
        ->sum('jumlah_cicilan');
    echo "\nTotal Cicilan (APPROVED only): Rp " . number_format($totalApproved, 0, ',', '.') . "\n";
} else {
    echo "Pendaftar tidak ditemukan\n";
}
