@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Daftar Pendaftar (Menunggu Validasi)</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            Tabel Pendaftar
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No. Formulir</th>
                            <th>Nama Siswa</th>
                            <th>Pilihan Jurusan</th>
                            <th>Status Formulir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftar as $data)
                        <tr>
                            <td>{{ $data->no_formulir }}</td>
                            <td>{{ $data->siswa?->nama_siswa ?? 'Belum Diisi' }}</td>
                            <td>{{ $data->siswa?->pilihan_jurusan ?? '-' }}</td>
                            <td><span class="badge bg-warning">{{ ucfirst($data->status_formulir) }}</span></td>
                            <td>
                                <a href="{{ route('panitia.validasi.show', $data->id) }}" class="btn btn-sm btn-info text-white">
                                    Detail & Validasi
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada pendaftar yang perlu divalidasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection