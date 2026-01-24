@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <h1 class="mt-4">Input Cicilan Pembayaran</h1>
            <p class="lead">{{ $pendaftar->siswa->nama_siswa }}</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <!-- Info Pembayaran -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Biaya Jurusan:</strong><br>
                            <span class="badge bg-primary">Rp {{ number_format($pendaftar->biaya_jurusan, 0, ',', '.') }}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Sudah Terbayar:</strong><br>
                            <span class="badge bg-success">Rp {{ number_format($pendaftar->total_terbayar, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Sisa Pembayaran:</strong><br>
                            <span class="badge bg-warning text-dark">Rp {{ number_format($pendaftar->calculateSisaPembayaran(), 0, ',', '.') }}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Status Pembayaran:</strong><br>
                            @if ($pendaftar->isSudahLunas())
                                <span class="badge bg-success">LUNAS</span>
                            @else
                                <span class="badge bg-warning text-dark">BELUM LUNAS</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Form Input Cicilan -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Input Cicilan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('bendahara.cicilan.store', $pendaftar->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="jumlah_cicilan" class="form-label">Jumlah Cicilan (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" 
                                    class="form-control @error('jumlah_cicilan') is-invalid @enderror" 
                                    id="jumlah_cicilan" 
                                    name="jumlah_cicilan" 
                                    value="{{ old('jumlah_cicilan') }}" 
                                    min="1"
                                    max="{{ $pendaftar->calculateSisaPembayaran() }}"
                                    step="1" 
                                    placeholder="Masukkan jumlah cicilan"
                                    required>
                                @error('jumlah_cicilan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                id="keterangan" 
                                name="keterangan" 
                                rows="3"
                                placeholder="Contoh: DP/Bayar pertama/Bayar kedua">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-between">
                            <a href="{{ route('bendahara.pembayaran.show', $pendaftar->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Cicilan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
