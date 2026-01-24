@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <h1 class="mt-4">Edit Harga Pendaftaran</h1>
            <p class="lead">{{ $jurusan->nama_jurusan }}</p>
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

    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('panitia.pricing.update', $jurusan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_jurusan" class="form-label">Nama Jurusan</label>
                            <input type="text" class="form-control" id="nama_jurusan" 
                                value="{{ $jurusan->nama_jurusan }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="biaya_pendaftaran" class="form-label">Biaya Pendaftaran (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" 
                                    class="form-control @error('biaya_pendaftaran') is-invalid @enderror" 
                                    id="biaya_pendaftaran" 
                                    name="biaya_pendaftaran" 
                                    value="{{ old('biaya_pendaftaran', $jurusan->biaya_pendaftaran) }}" 
                                    min="0" 
                                    step="0.01" 
                                    placeholder="Masukkan biaya pendaftaran"
                                    required>
                                @error('biaya_pendaftaran')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                Contoh: 350000 untuk Rp 350.000
                            </small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Informasi Jurusan</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">Kapasitas Slot:</small>
                                    <p class="fw-bold">{{ $jurusan->kapasitas_slot }}</p>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Terdaftar:</small>
                                    <p class="fw-bold">{{ $jurusan->terdaftar }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('panitia.pricing.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
