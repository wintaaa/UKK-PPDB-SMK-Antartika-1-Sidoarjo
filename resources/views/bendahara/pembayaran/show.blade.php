@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Proses Pembayaran</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Pendaftar</h5>
        </div>
        <div class="card-body">
            {{-- Detail Pendaftar --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>No. Formulir:</strong> {{ $pendaftar->no_formulir }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Nama Siswa:</strong> {{ $pendaftar->siswa?->nama_siswa ?? 'Belum Diisi' }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Jurusan:</strong> {{ $pendaftar->siswa?->pilihan_jurusan ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Status Pembayaran:</strong> 
                        @if ($pendaftar->isSudahLunas())
                            <span class="badge bg-success">LUNAS</span>
                        @else
                            <span class="badge bg-warning text-dark">BELUM LUNAS</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Pembayaran -->
    <div class="card shadow mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Informasi Pembayaran</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <strong>Biaya Jurusan:</strong><br>
                    <span class="badge bg-primary" style="font-size: 1rem;">
                        Rp {{ number_format($pendaftar->biaya_jurusan, 0, ',', '.') }}
                    </span>
                </div>
                <div class="col-md-4">
                    <strong>Sudah Terbayar:</strong><br>
                    <span class="badge bg-success" style="font-size: 1rem;">
                        Rp {{ number_format($pendaftar->total_terbayar, 0, ',', '.') }}
                    </span>
                </div>
                <div class="col-md-4">
                    <strong>Sisa Pembayaran:</strong><br>
                    <span class="badge bg-warning text-dark" style="font-size: 1rem;">
                        Rp {{ number_format($pendaftar->calculateSisaPembayaran(), 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    @if($pendaftar->status_pembayaran === 'belum_lunas')
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Input Pembayaran / Cicilan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('bendahara.pembayaran.proses', $pendaftar->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="jumlah_pembayaran" class="form-label">Jumlah Pembayaran</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" 
                            class="form-control @error('jumlah_pembayaran') is-invalid @enderror" 
                            id="jumlah_pembayaran" 
                            name="jumlah_pembayaran" 
                            value="{{ old('jumlah_pembayaran') }}"
                            min="1"
                            step="1"
                            placeholder="Masukkan jumlah pembayaran" 
                            required>
                        @error('jumlah_pembayaran')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('bendahara.dashboard.index') }}" class="btn btn-secondary">Kembali</a>
                    <div>
                        <a href="{{ route('bendahara.cicilan.history', $pendaftar->id) }}" class="btn btn-info">
                            <i class="fas fa-history"></i> Riwayat Cicilan
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Catat Pembayaran
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @else
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="alert alert-success text-center mb-0">
                <h5 class="mb-0">✓ Pembayaran sudah LUNAS</h5>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between">
        <a href="{{ route('bendahara.dashboard.index') }}" class="btn btn-secondary">Kembali</a>
        <div>
            <a href="{{ route('bendahara.cicilan.history', $pendaftar->id) }}" class="btn btn-info">
                <i class="fas fa-history"></i> Riwayat Cicilan
            </a>
            <a href="{{ route('bendahara.pembayaran.kwitansi', $pendaftar->id) }}" class="btn btn-success">
                <i class="fas fa-print"></i> Cetak Kwitansi
            </a>
        </div>
    </div>
    @endif
</div>
@endsection