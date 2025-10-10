{{-- resources/views/bendahara/pembayaran/show.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Detail Pendaftar dan Proses Pembayaran</h2>

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            Informasi Pendaftar
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nomor Formulir:</strong> {{ $pendaftar->no_formulir }}</p>
                    <p><strong>Nama Siswa:</strong> {{ $pendaftar->siswa?->nama_siswa ?? '-' }}</p>
                    <p><strong>Jurusan:</strong> {{ $pendaftar->siswa?->pilihan_jurusan ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Status Validasi:</strong> 
                        <span class="badge bg-success">{{ ucwords($pendaftar->status_validasi) }}</span>
                    </p>
                    <p><strong>Status Pembayaran:</strong> 
                        <span class="badge bg-warning text-dark">{{ ucwords(str_replace('_', ' ', $pendaftar->status_pembayaran)) }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if($pendaftar->status_pembayaran === 'belum_lunas')
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            Konfirmasi Pembayaran
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('bendahara.pembayaran.proses', $pendaftar->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="jumlah_pembayaran" class="form-label">Jumlah Pembayaran</label>
                    <input type="hidden" id="jumlah_pembayaran" name="jumlah_pembayaran" value="{{ $pendaftar->biaya_pendaftaran ?? 0 }}">
                </div>
                <button type="submit" class="btn btn-success">Konfirmasi Pembayaran Lunas</button>
                <a href="{{ route('bendahara.dashboard.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
    @else
    <div class="card shadow">
        <div class="card-body text-center">
            <h4 class="text-success">Pembayaran sudah lunas.</h4>
            <a href="{{ route('bendahara.pembayaran.kwitansi', $pendaftar->id) }}" class="btn btn-primary mt-3" target="_blank">
                <i class="fas fa-print me-2"></i>Cetak Kwitansi
            </a>
            <a href="{{ route('bendahara.dashboard.index') }}" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
        </div>
    </div>
    @endif
</div>
@endsection