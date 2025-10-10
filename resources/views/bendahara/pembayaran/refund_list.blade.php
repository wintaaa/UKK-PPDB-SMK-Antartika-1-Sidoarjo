@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Daftar Pendaftar (Sudah Refund)</h2>
    
    <div class="card shadow">
        <div class="card-header bg-danger text-white">
            Tabel Pendaftar Sudah Refund
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
                                <span class="badge bg-danger">{{ ucwords(str_replace('_', ' ', $data->status_pembayaran)) }}</span>
                            </td>
                            <td>
                                {{-- Aksi tambahan jika diperlukan, seperti melihat detail --}}
                                <button class="btn btn-sm btn-secondary" disabled>Lihat Detail</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada pendaftar yang statusnya refund.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection