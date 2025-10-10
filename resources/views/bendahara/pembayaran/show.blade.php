@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Proses Pembayaran</h2>

    <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
            Pembayaran untuk **{{ $pendaftar->siswa?->nama_siswa ?? 'Pendaftar' }}**
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
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
                    <p><strong>Status Pembayaran:</strong> <span class="badge {{ $pendaftar->status_pembayaran == 'lunas' ? 'bg-success' : 'bg-warning text-dark' }}">{{ ucwords(str_replace('_', ' ', $pendaftar->status_pembayaran)) }}</span></p>
                </div>
            </div>

            <hr>

            @if($pendaftar->status_pembayaran === 'belum_lunas')
            <form action="{{ route('bendahara.pembayaran.proses', $pendaftar->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="jumlah_pembayaran" class="form-label">Jumlah Pembayaran</label>
                    <input type="number" class="form-control" id="jumlah_pembayaran" name="jumlah_pembayaran" placeholder="Masukkan jumlah pembayaran" required>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('bendahara.dashboard.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Catat Pembayaran</button>
                </div>
            </form>
            @else
            <div class="alert alert-success text-center">
                Pembayaran sudah lunas.
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('bendahara.dashboard.index') }}" class="btn btn-secondary">Kembali</a>
                <a href="{{ route('bendahara.pembayaran.kwitansi', $pendaftar->id) }}" class="btn btn-success">Cetak Kwitansi</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection