<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan PPDB SMK Antartika</title>
    <style>
        body { font-family: 'Arial', sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 5px 0; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
        .footer { text-align: center; margin-top: 20px; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Data Pendaftar PPDB</h1>
        <p>SMK Antartika Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No. Formulir</th>
                <th>Nama Siswa</th>
                <th>Jurusan</th>
                <th>Status Formulir</th>
                <th>Status Validasi</th>
                <th>Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendaftar as $data)
            <tr>
                <td>{{ $data->no_formulir }}</td>
                <td>{{ $data->siswa?->nama_siswa ?? '-' }}</td>
                <td>{{ $data->siswa?->pilihan_jurusan ?? '-' }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $data->status_formulir)) }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $data->status_validasi)) }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $data->status_pembayaran)) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada tanggal: {{ date('d-m-Y H:i:s') }}
    </div>
</body>
</html>