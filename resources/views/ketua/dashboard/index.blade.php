@extends('layouts.app')

@section('content')
    <h2 class="mb-4 text-center">Dashboard PPDB SMK Antartika</h2>
    
    {{-- Ringkasan Statistik --}}
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card shadow stats-card">
                <div class="card-body">
                    <div class="icon-box bg-primary">
                        <i class="fas fa-users"></i>
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
                        <i class="fas fa-file-export"></i>
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
                        <i class="fas fa-file-import"></i>
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
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stats-text">
                        <h5>{{ $pendaftarLolos }}</h5>
                        <p>Lolos Validasi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Statistik per Jurusan dan Pembayaran --}}
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
                            <i class="fas fa-wallet"></i>
                        </span>
                    </div>
                    
                    {{-- Tautan untuk Laporan PDF --}}
                    <a href="{{ route('ketua.laporan.pdf') }}" class="btn btn-success d-block mb-2">
                        Download Laporan PDF
                    </a>
                    
                    {{-- Tautan untuk Backup Database --}}
                    <a href="{{ route('ketua.backup') }}" class="btn btn-warning d-block mb-2">
                        Backup Database
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection