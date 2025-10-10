<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="card-title mb-0">Formulir Pendaftaran Siswa Baru</h2>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('panitia.pendaftaran.store') }}" method="POST">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="no_formulir" class="form-label fw-bold">No Formulir</label>
                        <input type="text" class="form-control" id="no_formulir" name="no_formulir" value="{{ old('no_formulir', $pendaftar->no_formulir) }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_pendaftaran" class="form-label fw-bold">Tanggal Pendaftaran</label>
                        <input type="text" class="form-control" id="tanggal_pendaftaran" name="tanggal_pendaftaran" value="{{ now()->format('d F Y') }}" readonly>
                    </div>
                </div>

                {{-- Data Siswa --}}
                <h4 class="mt-4 mb-3 border-bottom pb-2">A. Data Siswa</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_siswa" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa') }}" required>
                        @error('nama_siswa')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">Pilih...</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="nisn" class="form-label">NISN</label>
                        <input type="text" class="form-control" id="nisn" name="nisn" value="{{ old('nisn') }}" required>
                        @error('nisn')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik') }}" required>
                        @error('nik')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="npsn_sekolah_asal" class="form-label">NPSN Sekolah Asal</label>
                        <input type="text" class="form-control" id="npsn_sekolah_asal" name="npsn_sekolah_asal" value="{{ old('npsn_sekolah_asal') }}" required>
                        @error('npsn_sekolah_asal')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="nama_sekolah_asal" class="form-label">Nama Sekolah Asal</label>
                        <input type="text" class="form-control" id="nama_sekolah_asal" name="nama_sekolah_asal" value="{{ old('nama_sekolah_asal') }}" required>
                        @error('nama_sekolah_asal')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required>
                        @error('tempat_lahir')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                        @error('tanggal_lahir')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="agama" class="form-label">Agama</label>
                        <input type="text" class="form-control" id="agama" name="agama" value="{{ old('agama') }}" required>
                        @error('agama')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat') }}" required>
                        @error('alamat')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="dusun" class="form-label">Dusun</label>
                        <input type="text" class="form-control" id="dusun" name="dusun" value="{{ old('dusun') }}">
                        @error('dusun')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="rt_rw" class="form-label">RT/RW</label>
                        <input type="text" class="form-control" id="rt_rw" name="rt_rw" value="{{ old('rt_rw') }}">
                        @error('rt_rw')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}" required>
                        @error('kecamatan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="desa_kelurahan" class="form-label">Desa/Kelurahan</label>
                        <input type="text" class="form-control" id="desa_kelurahan" name="desa_kelurahan" value="{{ old('desa_kelurahan') }}" required>
                        @error('desa_kelurahan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="kabupaten_kota" class="form-label">Kabupaten/Kota</label>
                        <input type="text" class="form-control" id="kabupaten_kota" name="kabupaten_kota" value="{{ old('kabupaten_kota') }}" required>
                        @error('kabupaten_kota')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="alat_transportasi" class="form-label">Alat Transportasi</label>
                        <input type="text" class="form-control" id="alat_transportasi" name="alat_transportasi" value="{{ old('alat_transportasi') }}" required>
                        @error('alat_transportasi')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="anak_ke" class="form-label">Anak ke-</label>
                        <input type="number" class="form-control" id="anak_ke" name="anak_ke" value="{{ old('anak_ke') }}" required>
                        @error('anak_ke')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="jumlah_saudara" class="form-label">Jumlah Saudara Kandung</label>
                        <input type="number" class="form-control" id="jumlah_saudara" name="jumlah_saudara" value="{{ old('jumlah_saudara') }}" required>
                        @error('jumlah_saudara')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="jenis_tinggal" class="form-label">Jenis Tinggal</label>
                        <input type="text" class="form-control" id="jenis_tinggal" name="jenis_tinggal" value="{{ old('jenis_tinggal') }}" required>
                        @error('jenis_tinggal')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="no_telp_rumah" class="form-label">No. Telp Rumah</label>
                        <input type="text" class="form-control" id="no_telp_rumah" name="no_telp_rumah" value="{{ old('no_telp_rumah') }}">
                        @error('no_telp_rumah')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="no_hp_wa" class="form-label">No. HP (WA)</label>
                        <input type="text" class="form-control" id="no_hp_wa" name="no_hp_wa" value="{{ old('no_hp_wa') }}" required>
                        @error('no_hp_wa')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Data Ayah Kandung --}}
                <h4 class="mt-5 mb-3 border-bottom pb-2">B. Data Ayah Kandung</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_ayah" class="form-label">Nama Ayah</label>
                        <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah') }}" required>
                        @error('nama_ayah')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="tahun_lahir_ayah" class="form-label">Tahun Lahir</label>
                        <input type="number" class="form-control" id="tahun_lahir_ayah" name="tahun_lahir_ayah" value="{{ old('tahun_lahir_ayah') }}" required>
                        @error('tahun_lahir_ayah')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="nik_ayah" class="form-label">NIK Ayah</label>
                        <input type="text" class="form-control" id="nik_ayah" name="nik_ayah" value="{{ old('nik_ayah') }}" required>
                        @error('nik_ayah')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="pendidikan_ayah" class="form-label">Pendidikan Ayah</label>
                        <input type="text" class="form-control" id="pendidikan_ayah" name="pendidikan_ayah" value="{{ old('pendidikan_ayah') }}" required>
                        @error('pendidikan_ayah')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                        <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" required>
                        @error('pekerjaan_ayah')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="penghasilan_ayah" class="form-label">Penghasilan Bulanan Ayah</label>
                        <input type="text" class="form-control" id="penghasilan_ayah" name="penghasilan_ayah" value="{{ old('penghasilan_ayah') }}" required>
                        @error('penghasilan_ayah')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Data Ibu Kandung --}}
                <h4 class="mt-5 mb-3 border-bottom pb-2">C. Data Ibu Kandung</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_ibu" class="form-label">Nama Ibu</label>
                        <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu') }}" required>
                        @error('nama_ibu')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="tahun_lahir_ibu" class="form-label">Tahun Lahir</label>
                        <input type="number" class="form-control" id="tahun_lahir_ibu" name="tahun_lahir_ibu" value="{{ old('tahun_lahir_ibu') }}" required>
                        @error('tahun_lahir_ibu')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="nik_ibu" class="form-label">NIK Ibu</label>
                        <input type="text" class="form-control" id="nik_ibu" name="nik_ibu" value="{{ old('nik_ibu') }}" required>
                        @error('nik_ibu')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="pendidikan_ibu" class="form-label">Pendidikan Ibu</label>
                        <input type="text" class="form-control" id="pendidikan_ibu" name="pendidikan_ibu" value="{{ old('pendidikan_ibu') }}" required>
                        @error('pendidikan_ibu')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                        <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" required>
                        @error('pekerjaan_ibu')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="penghasilan_ibu" class="form-label">Penghasilan Bulanan Ibu</label>
                        <input type="text" class="form-control" id="penghasilan_ibu" name="penghasilan_ibu" value="{{ old('penghasilan_ibu') }}" required>
                        @error('penghasilan_ibu')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Data Wali --}}
                <h4 class="mt-5 mb-3 border-bottom pb-2">D. Data Wali (Opsional)</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_wali" class="form-label">Nama Wali</label>
                        <input type="text" class="form-control" id="nama_wali" name="nama_wali" value="{{ old('nama_wali') }}">
                        @error('nama_wali')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="tahun_lahir_wali" class="form-label">Tahun Lahir</label>
                        <input type="number" class="form-control" id="tahun_lahir_wali" name="tahun_lahir_wali" value="{{ old('tahun_lahir_wali') }}">
                        @error('tahun_lahir_wali')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="nik_wali" class="form-label">NIK Wali</label>
                        <input type="text" class="form-control" id="nik_wali" name="nik_wali" value="{{ old('nik_wali') }}">
                        @error('nik_wali')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="pendidikan_wali" class="form-label">Pendidikan Wali</label>
                        <input type="text" class="form-control" id="pendidikan_wali" name="pendidikan_wali" value="{{ old('pendidikan_wali') }}">
                        @error('pendidikan_wali')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="pekerjaan_wali" class="form-label">Pekerjaan Wali</label>
                        <input type="text" class="form-control" id="pekerjaan_wali" name="pekerjaan_wali" value="{{ old('pekerjaan_wali') }}">
                        @error('pekerjaan_wali')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="penghasilan_wali" class="form-label">Penghasilan Bulanan Wali</label>
                        <input type="text" class="form-control" id="penghasilan_wali" name="penghasilan_wali" value="{{ old('penghasilan_wali') }}">
                        @error('penghasilan_wali')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Data Periodik --}}
                <h4 class="mt-5 mb-3 border-bottom pb-2">E. Data Periodik</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                        <input type="number" class="form-control" id="tinggi_badan" name="tinggi_badan" value="{{ old('tinggi_badan') }}" required>
                        @error('tinggi_badan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                        <input type="number" class="form-control" id="berat_badan" name="berat_badan" value="{{ old('berat_badan') }}" required>
                        @error('berat_badan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="jarak_tempuh" class="form-label">Jarak Tempuh ke Sekolah (km)</label>
                        <input type="number" class="form-control" id="jarak_tempuh" name="jarak_tempuh" value="{{ old('jarak_tempuh') }}" required>
                        @error('jarak_tempuh')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="waktu_tempuh" class="form-label">Waktu Tempuh (menit)</label>
                        <input type="number" class="form-control" id="waktu_tempuh" name="waktu_tempuh" value="{{ old('waktu_tempuh') }}" required>
                        @error('waktu_tempuh')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="jumlah_saudara" class="form-label">Jumlah Saudara Kandung</label>
                        <input type="number" class="form-control" id="jumlah_saudara" name="jumlah_saudara" value="{{ old('jumlah_saudara') }}" required>
                        @error('jumlah_saudara')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Pilihan Jurusan --}}
                <h4 class="mt-5 mb-3 border-bottom pb-2">F. Pilihan Jurusan</h4>
                <div class="mb-3">
                    <label for="jurusan_id" class="form-label">Pilihan Jurusan</label>
                    <select class="form-select" id="jurusan_id" name="jurusan_id" required>
                        <option value="">Pilih Jurusan</option>
                        @foreach ($jurusan as $j)
                            <option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>{{ $j->nama_jurusan }}</option>
                        @endforeach
                    </select>
                    @error('jurusan_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                {{-- Fitur Checklist (Hanya untuk Tampilan, akan divalidasi manual) --}}
                <h4 class="mt-5 mb-3 border-bottom pb-2">G. Kelengkapan Dokumen</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ijazah_smp" disabled>
                            <label class="form-check-label" for="ijazah_smp">Ijazah SMP</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="kk" disabled>
                            <label class="form-check-label" for="kk">KK</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="akta_kelahiran" disabled>
                            <label class="form-check-label" for="akta_kelahiran">Akta Kelahiran</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="foto" disabled>
                            <label class="form-check-label" for="foto">Foto</label>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-primary btn-lg">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>