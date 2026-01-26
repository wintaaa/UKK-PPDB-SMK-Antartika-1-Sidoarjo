<!DOCTYPE html>
<html>
<head>
    <title>Kwitansi Cicilan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .info { margin-top: 20px; }
        .footer { margin-top: 30px; text-align: right; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-section { background-color: #eee; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>KWITANSI PEMBAYARAN CICILAN</h2>
        <p>SMK ANTARTIKA - PPDB 2026</p>
    </div>

    <div class="info">
        <p><strong>No. Formulir:</strong> {{ $pendaftar->no_formulir }}</p>
        <p><strong>Nama Siswa:</strong> {{ $pendaftar->siswa->nama_siswa }}</p>
        <p><strong>Total Biaya Jurusan:</strong> Rp {{ number_format($pendaftar->biaya_jurusan, 0, ',', '.') }}</p>
    </div>

    <hr>

    <h3>Rincian Pembayaran Saat Ini</h3>
    <table>
        <tr>
            <th>Tanggal Bayar</th>
            <th>Nominal Bayar</th>
            <th>Keterangan</th>
        </tr>
        <tr>
            <td>{{ \Carbon\Carbon::parse($cicilanUtama->tanggal_pembayaran)->format('d/m/Y') }}</td>
            <td><strong>Rp {{ number_format($cicilanUtama->jumlah_cicilan, 0, ',', '.') }}</strong></td>
            <td>{{ $cicilanUtama->keterangan ?? 'Cicilan' }}</td>
        </tr>
    </table>

    <h3>Riwayat Pembayaran Sebelumnya</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php $totalMasuk = 0; @endphp
            @foreach($riwayatCicilan as $index => $item)
                @php $totalMasuk += $item->jumlah_cicilan; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pembayaran)->format('d/m/Y') }}</td>
                    <td>Rp {{ number_format($item->jumlah_cicilan, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total-section">
                <td colspan="2" style="text-align: right;">Total Sudah Terbayar:</td>
                <td>Rp {{ number_format($totalMasuk, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-section" style="color: red;">
                <td colspan="2" style="text-align: right;">SISA PEMBAYARAN:</td>
                <td>Rp {{ number_format($sisaPembayaran, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Sidoarjo, {{ $tanggal_cetak }}</p>
        <br><br><br>
        <p>( Bendahara PPDB )</p>
    </div>
</body>
</html>