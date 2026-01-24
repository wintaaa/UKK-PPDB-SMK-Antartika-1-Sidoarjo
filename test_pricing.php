<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Jurusan;

echo "\n=== DATA HARGA JURUSAN ===\n";
echo str_repeat("=", 60) . "\n";

$jurusans = Jurusan::orderBy('nama_jurusan')->get();

foreach ($jurusans as $jurusan) {
    echo sprintf(
        "%-35s | Rp %s\n",
        $jurusan->nama_jurusan,
        number_format($jurusan->biaya_pendaftaran, 0, ',', '.')
    );
}

echo str_repeat("=", 60) . "\n";
echo "\nTotal Jurusan: " . $jurusans->count() . "\n\n";
