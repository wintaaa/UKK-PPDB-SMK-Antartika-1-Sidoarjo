@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Dashboard Panitia</h1>
    <p class="lead mb-4">Ringkasan status formulir pendaftaran.</p>

    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Formulir Keluar</h5>
                            <p class="card-text fs-2 fw-bold">{{ $formulirKeluar }}</p>
                        </div>
                        <i class="fas fa-file-alt fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Formulir Kembali</h5>
                            <p class="card-text fs-2 fw-bold">{{ $formulirKembali }}</p>
                        </div>
                        <i class="fas fa-check-square fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <h4>Menu Cepat</h4>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-around flex-wrap">
                <a href="{{ route('panitia.input_form_number') }}" class="btn btn-lg btn-outline-primary m-2">
                    <i class="fas fa-edit d-block mb-2"></i> Input Data
                </a>
                <a href="{{ route('panitia.validasi.index') }}" class="btn btn-lg btn-outline-success m-2">
                    <i class="fas fa-check-circle d-block mb-2"></i> Validasi
                </a>
                <a href="{{ route('panitia.cetak.formulir') }}" class="btn btn-lg btn-outline-info m-2">
                    <i class="fas fa-print d-block mb-2"></i> Cetak Formulir
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h4>Daftar Status Formulir</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No. Formulir</th>
                            <th>Status Formulir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($daftarPendaftar as $pendaftar)
                        <tr>
                            <td>{{ $pendaftar->no_formulir }}</td>
                            <td>
                                @if($pendaftar->status_formulir == 'sudah_kembali')
                                    <span class="badge bg-success">Sudah Kembali</span>
                                @else
                                    <span class="badge bg-warning text-dark">Keluar</span>
                                @endif
                            </td>
                            <td>
                                @if($pendaftar->status_formulir == 'keluar')
                                    <a href="{{ route('panitia.pendaftaran.create', ['no_formulir' => $pendaftar->no_formulir]) }}" class="btn btn-sm btn-outline-primary">Input Data</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection