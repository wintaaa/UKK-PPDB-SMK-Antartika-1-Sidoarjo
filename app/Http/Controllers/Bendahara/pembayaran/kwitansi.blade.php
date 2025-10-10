<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; }
        .kwitansi-container { width: 80mm; margin: 0 auto; padding: 10mm; border: 1px solid #000; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h3 { margin: 0; }
        .details p { margin: 5px 0; font-size: 14px; }
        .footer { text-align: right; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="kwitansi-container">
        <div class="header">
            <h3>KWITANSI PEMBAYARAN PPDB</h3>
            <h4>SMK Antartika</h4>
            <hr>
        </div>
        <div class="details">
            <p><strong>Nomor Kwitansi:</strong> {{ $pendaftar->no_formulir }}</p>
            <p><strong>Telah diterima dari:</strong> {{ $pendaftar->siswa?->nama_siswa ?? 'Tidak Diketahui' }}</p>
            <p><strong>Untuk pembayaran:</strong> Biaya Pendaftaran PPDB</p>
            <p><strong>Jumlah:</strong> Rp. 500.000,-</p>
            <p><strong>Tanggal:</strong> {{ $tanggal_cetak }}</p>
        </div>
        <div class="footer">
            <p>Hormat kami,</p>
            <br><br>
            <p>(Bendahara PPDB)</p>
        </div>
    </div>
</body>
</html>