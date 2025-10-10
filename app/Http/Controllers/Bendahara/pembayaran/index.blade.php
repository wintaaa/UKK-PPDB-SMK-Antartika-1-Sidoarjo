{{-- resources/views/bendahara/dashboard/index.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Dashboard Bendahara</h2>

    <div class="card shadow">
        <div class="card-header bg-warning text-dark">
            <i class="fas fa-money-bill-wave me-2"></i>Tabel Pendaftar Belum Lunas
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
                                <span class="badge bg-warning text-dark">
                                    {{ ucwords(str_replace('_', ' ', $data->status_pembayaran)) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('bendahara.pembayaran.show', $data->id) }}" class="btn btn-sm btn-primary">
                                    Proses Pembayaran
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada pendaftar yang belum melunasi pembayaran.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection