<!DOCTYPE html>
<html>

<head>
    <title>Kwitansi Pembayaran PPDB</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            line-height: 1.6;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .info-section {
            margin-bottom: 20px;
        }

        .info-section p {
            margin: 5px 0;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .signature-box {
            text-align: center;
            width: 45%;
        }

        .signature-line {
            height: 1px;
            background-color: #000;
            width: 150px;
            margin: 0 auto;
            margin-top: 50px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #888;
        }

        .terbilang {
            font-style: italic;
            border: 1px dashed #000;
            padding: 5px;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h1>KWITANSI PEMBAYARAN</h1>
            <p>PPDB SMK Antartika</p>
            <p>Tahun Ajaran 2024/2025</p>
        </div>

        <div class="info-section">
            <p><strong>Telah terima dari:</strong> {{ $pendaftar->siswa->nama_siswa ?? '-' }}</p>
            <p><strong>Untuk pembayaran:</strong> Biaya Pendaftaran PPDB</p>
            <p><strong>Jumlah uang:</strong> Rp {{ number_format($pendaftar->biaya_pendaftaran, 0, ',', '.') }}</p>

            <div class="terbilang">
                Terbilang: **{{ ucwords(\App\Helpers\NumberToWords::toWords($pendaftar->biaya_pendaftaran)) }} Rupiah**
            </div>
        </div>

        <div class="info-section">
            <p><strong>Nomor Formulir:</strong> {{ $pendaftar->no_formulir }}</p>
            <p><strong>Tanggal Pembayaran:</strong> {{ $pendaftar->tanggal_pembayaran ? \Carbon\Carbon::parse($pendaftar->tanggal_pembayaran)->format('d F Y') : $pendaftar->updated_at->format('d F Y') }}</p>
        </div>

        <div class="signature-section">
            <div class="signature-box">
                <p>Pendaftar</p>
                <div class="signature-line"></div>
                <p>{{ $pendaftar->siswa->nama_siswa ?? '-' }}</p>
            </div>
            <div class="signature-box">
                <p>Bendahara</p>
                <div class="signature-line"></div>
                <p>({{ Auth::user()->name ?? '-' }})</p>
            </div>
        </div>

        <div class="footer">
            <p>*Kwitansi ini adalah bukti pembayaran yang sah*</p>
        </div>
    </div>

</body>

</html>