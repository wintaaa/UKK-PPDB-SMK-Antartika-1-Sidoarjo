@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mt-4">Kelola Harga Pendaftaran Per Jurusan</h1>
            <p class="lead">Atur biaya pendaftaran untuk setiap jurusan</p>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="40%">Nama Jurusan</th>
                            <th width="20%" class="text-end">Biaya Pendaftaran</th>
                            <th width="15%">Kapasitas</th>
                            <th width="15%">Terdaftar</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jurusans as $jurusan)
                            <tr>
                                <td>
                                    <strong>{{ $jurusan->nama_jurusan }}</strong>
                                </td>
                                <td class="text-end">
                                    <span class="badge bg-info text-dark">
                                        Rp {{ number_format($jurusan->biaya_pendaftaran, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>{{ $jurusan->kapasitas_slot }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $jurusan->terdaftar }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('panitia.pricing.edit', $jurusan->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('panitia.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
