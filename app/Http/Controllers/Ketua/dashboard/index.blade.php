<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin PPDB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }
        .container { margin-top: 30px; }
        .card { border: none; border-radius: 10px; }
        .icon-box { background-color: #0d6efd; color: white; padding: 15px; border-radius: 8px; font-size: 2rem; }
        .stats-card .card-body { display: flex; align-items: center; justify-content: space-between; }
        .stats-text { text-align: right; }
        .stats-text h5 { margin-bottom: 0; font-weight: 600; }
        .stats-text p { color: #6c757d; font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4 text-center">Dashboard PPDB SMK Antartika</h2>
        
        {{-- Ringkasan Statistik --}}
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card shadow stats-card">
                    <div class="card-body">
                        <div class="icon-box bg-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.466 3.996-2.582.52 1.571-3.14a4 4 0 0 1-.983-3.14l-1.558-2.613L7.3 1z"/>
                                <path fill-rule="evenodd" d="M11 7a4 4 0 1 0 0-8 4 4 0 0 0 0 8m-5.466 3.996-2.582.52C2.79 13.91 1 12.28 1 10a4 4 0 0 1 5-3.535l1.558 2.613z"/>
                            </svg>
                        </div>
                        <div class="stats-text">
                            <h5>{{ $totalPendaftar }}</h5>
                            <p>Total Pendaftar</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card shadow stats-card">
                    <div class="card-body">
                        <div class="icon-box bg-info">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-file-earmark-text-fill" viewBox="0 0 16 16">
                                <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 0.293zM9.5 3.5v-2L12 3l-2.5 1zm-2-2L9.5 3.5h-2zM4.5 10a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z"/>
                            </svg>
                        </div>
                        <div class="stats-text">
                            <h5>{{ $formulirKeluar }}</h5>
                            <p>Formulir Keluar</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card shadow stats-card">
                    <div class="card-body">
                        <div class="icon-box bg-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-return-right" viewBox="0 0 16 16">
                                <path d="M1 5.5A.5.5 0 0 1 1.5 5H10a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V6.207L6.854 9.354a.5.5 0 0 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L9.5 6.207z"/>
                            </svg>
                        </div>
                        <div class="stats-text">
                            <h5>{{ $formulirKembali }}</h5>
                            <p>Formulir Kembali</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card shadow stats-card">
                    <div class="card-body">
                        <div class="icon-box bg-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.497 5.758 7.778a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.134-.022l3.4-4.8a.75.75 0 0 0-.022-1.134z"/>
                            </svg>
                        </div>
                        <div class="stats-text">
                            <h5>{{ $pendaftarLolos }}</h5>
                            <p>Lolos Validasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header text-white bg-primary">
                        Statistik Pendaftar per Jurusan
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Jurusan</th>
                                    <th>Jumlah Pendaftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statistikJurusan as $data)
                                <tr>
                                    <td>{{ $data->pilihan_jurusan }}</td>
                                    <td>{{ $data->total }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header text-white bg-success">
                        Status Pembayaran & Laporan
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="mb-0">{{ $pembayaranLunas }}</h5>
                                <p class="text-muted">Pembayaran Lunas</p>
                            </div>
                            <span class="fs-1 text-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-wallet2" viewBox="0 0 16 16">
                                    <path d="M12.18 4H3.82C3.37 4 3 4.37 3 4.82v8.36C3 13.63 3.37 14 3.82 14h8.36c.45 0 .82-.37.82-.82V4.82c0-.45-.37-.82-.82-.82zM4 5.5h8v7H4z"/>
                                    <path d="M.5 1a.5.5 0 0 0 0 1h.5v12a.5.5 0 0 0 1 0V2h12a.5.5 0 0 0 0-1H.5z"/>
                                </svg>
                            </span>
                        </div>
                        <a href="{{ route('ketua.laporan.excel') }}" class="btn btn-success d-block mb-2">
                            Download Laporan Excel
                        </a>
                        <a href="#" class="btn btn-warning d-block mb-2">
                            Backup Database
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>