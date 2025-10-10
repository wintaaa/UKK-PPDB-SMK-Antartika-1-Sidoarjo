<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Data - {{ $pendaftar->siswa->nama_siswa ?? 'Pendaftar' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
            margin-bottom: 50px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            font-size: 1.25rem;
        }
        .form-check-input {
            margin-top: 0.3em;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card shadow">
            <div class="card-header text-center">
                Validasi Data Pendaftar <br> **{{ $pendaftar->siswa?->nama_siswa ?? 'Data Siswa Belum Diisi' }}**
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('panitia.validasi.update', $pendaftar->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- Informasi Pendaftar --}}
                    <h5 class="mt-3">Informasi Umum</h5>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nomor Formulir:</label>
                            <p><strong>{{ $pendaftar->no_formulir }}</strong></p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pendaftaran:</label>
                            <p><strong>{{ \Carbon\Carbon::parse($pendaftar->tanggal_pendaftaran)->format('d F Y') }}</strong></p>
                        </div>
                    </div>

                    {{-- Bagian Data Siswa --}}
                    <h5 class="mt-4">A. Data Siswa</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-3"><p><strong>Nama:</strong> {{ $pendaftar->siswa?->nama_siswa }}</p></div>
                        <div class="col-md-6 mb-3"><p><strong>Jenis Kelamin:</strong> {{ $pendaftar->siswa?->jenis_kelamin }}</p></div>
                        <div class="col-md-6 mb-3"><p><strong>NISN:</strong> {{ $pendaftar->siswa?->nisn }}</p></div>
                        <div class="col-md-6 mb-3"><p><strong>NIK:</strong> {{ $pendaftar->siswa?->nik }}</p></div>
                        <div class="col-md-6 mb-3"><p><strong>Sekolah Asal:</strong> {{ $pendaftar->siswa?->nama_sekolah_asal }}</p></div>
                        <div class="col-md-6 mb-3"><p><strong>Tempat, Tanggal Lahir:</strong> {{ $pendaftar->siswa?->tempat_lahir }}, {{ \Carbon\Carbon::parse($pendaftar->siswa?->tanggal_lahir)->format('d F Y') }}</p></div>
                        <div class="col-md-12 mb-3"><p><strong>Alamat:</strong> {{ $pendaftar->siswa?->alamat }}, Ds. {{ $pendaftar->siswa?->desa_kelurahan }}, Kec. {{ $pendaftar->siswa?->kecamatan }}, {{ $pendaftar->siswa?->kabupaten_kota }}</p></div>
                        {{-- Tampilkan semua data siswa lainnya --}}
                        <div class="col-md-6 mb-3"><p><strong>Pilihan Jurusan:</strong> {{ $pendaftar->siswa?->pilihan_jurusan }}</p></div>
                    </div>

                    {{-- Bagian Data Orang Tua --}}
                    <h5 class="mt-4">B. Data Orang Tua</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-3"><p><strong>Nama Ayah:</strong> {{ $pendaftar->dataOrangTua?->nama_ayah }}</p></div>
                        <div class="col-md-6 mb-3"><p><strong>Nama Ibu:</strong> {{ $pendaftar->dataOrangTua?->nama_ibu }}</p></div>
                        {{-- Tampilkan semua data orang tua lainnya --}}
                    </div>

                    {{-- Bagian Data Wali (jika ada) --}}
                    @if($pendaftar->dataWali)
                    <h5 class="mt-4">C. Data Wali</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 mb-3"><p><strong>Nama Wali:</strong> {{ $pendaftar->dataWali->nama_wali }}</p></div>
                        {{-- Tampilkan semua data wali lainnya --}}
                    </div>
                    @endif

                    {{-- Bagian Checklist Dokumen --}}
                    <div class="card bg-light p-3 mt-4">
                        <h5 class="mb-3">D. Kelengkapan Dokumen</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="ijazah_smp" value="1" id="checkIjazah" {{ $pendaftar->siswa?->ijazah_smp ? 'checked' : '' }}>
                                    <label class="form-check-label" for="checkIjazah">Ijazah SMP</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="kk" value="1" id="checkKK" {{ $pendaftar->siswa?->kk ? 'checked' : '' }}>
                                    <label class="form-check-label" for="checkKK">Kartu Keluarga (KK)</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="akta_kelahiran" value="1" id="checkAkta" {{ $pendaftar->siswa?->akta_kelahiran ? 'checked' : '' }}>
                                    <label class="form-check-label" for="checkAkta">Akta Kelahiran</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="foto" value="1" id="checkFoto" {{ $pendaftar->siswa?->foto ? 'checked' : '' }}>
                                    <label class="form-check-label" for="checkFoto">Foto</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bagian Status Validasi --}}
                    <div class="mt-4">
                        <h5 class="mb-3">Status Validasi</h5>
                        <select class="form-select" name="status_validasi" required>
                            <option value="belum_lengkap" {{ $pendaftar->status_validasi == 'belum_lengkap' ? 'selected' : '' }}>Belum Lengkap</option>
                            <option value="lolos_validasi" {{ $pendaftar->status_validasi == 'lolos_validasi' ? 'selected' : '' }}>Lolos Validasi</option>
                        </select>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('panitia.validasi.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Validasi</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>
</html>