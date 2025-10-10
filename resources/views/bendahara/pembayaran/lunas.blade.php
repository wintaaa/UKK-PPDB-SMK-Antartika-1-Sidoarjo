@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Daftar Pendaftar (Sudah Lunas)</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-header bg-success text-white">
            Tabel Pendaftar Sudah Lunas
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No. Formulir</th>
                            <th>Nama Siswa</th>
                            <th>Status Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftar as $data)
                        <tr>
                            <td>{{ $data->no_formulir }}</td>
                            <td>{{ $data->siswa?->nama_siswa ?? 'Belum Diisi' }}</td>
                            <td>
                                <span class="badge bg-success">{{ ucwords(str_replace('_', ' ', $data->status_pembayaran)) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('bendahara.pembayaran.kwitansi', $data->id) }}" class="btn btn-sm btn-info text-white me-2">
                                    <i class="fas fa-print me-1"></i> Cetak Kwitansi
                                </a>
                                <form action="{{ route('bendahara.pembayaran.refund', $data->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin memproses refund untuk pendaftar ini?')">
                                        <i class="fas fa-undo-alt me-1"></i> Proses Refund
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada pendaftar yang sudah melunasi pembayaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection