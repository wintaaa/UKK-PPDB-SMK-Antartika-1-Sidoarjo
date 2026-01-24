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
            <form action="{{ route('panitia.pendaftaran.store') }}" method="POST">
                @csrf
                
                {{-- Data Pendaftaran --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="no_formulir" class="form-label fw-bold">No Formulir</label>
                        <input type="text" class="form-control" id="no_formulir" name="no_formulir" value="{{ $pendaftar->no_formulir }}" readonly>
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
                        <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" required>
                    </div>
                    <div class="col-md-6">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">Pilih...</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="nisn" class="form-label">NISN</label>
                        <input type="text" class="form-control" id="nisn" name="nisn" inputmode="numeric" pattern="[0-9]*" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" inputmode="numeric" pattern="[0-9]*" required>
                    </div>
                    <div class="col-md-6">
                        <label for="npsn_sekolah_asal" class="form-label">NPSN Sekolah Asal</label>
                        <input type="text" class="form-control" id="npsn_sekolah_asal" name="npsn_sekolah_asal" inputmode="numeric" pattern="[0-9]*" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nama_sekolah_asal" class="form-label">Nama Sekolah Asal</label>
                        <input type="text" class="form-control" id="nama_sekolah_asal" name="nama_sekolah_asal" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                    </div>
                    <div class="col-md-6">
                        <label for="agama" class="form-label">Agama</label>
                        <input type="text" class="form-control" id="agama" name="agama" required>
                    </div>
                    <div class="col-12">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="col-md-4">
                        <label for="dusun" class="form-label">Dusun</label>
                        <input type="text" class="form-control" id="dusun" name="dusun">
                    </div>
                    <div class="col-md-4">
                        <label for="rt_rw" class="form-label">RT/RW</label>
                        <input type="text" class="form-control" id="rt_rw" name="rt_rw">
                    </div>
                    <div class="col-md-4">
                        <label for="kecamatan" class="form-label">Kecamatan</label>
                        <input type="text" class="form-control" id="kecamatan" name="kecamatan" required>
                    </div>
                    <div class="col-md-6">
                        <label for="desa_kelurahan" class="form-label">Desa/Kelurahan</label>
                        <input type="text" class="form-control" id="desa_kelurahan" name="desa_kelurahan" required>
                    </div>
                    <div class="col-md-6">
                        <label for="kabupaten_kota" class="form-label">Kabupaten/Kota</label>
                        <input type="text" class="form-control" id="kabupaten_kota" name="kabupaten_kota" required>
                    </div>
                    <div class="col-md-6">
                        <label for="alat_transportasi" class="form-label">Alat Transportasi</label>
                        <input type="text" class="form-control" id="alat_transportasi" name="alat_transportasi" required>
                    </div>
                    <div class="col-md-3">
                        <label for="anak_ke" class="form-label">Anak ke-</label>
                        <input type="number" class="form-control" id="anak_ke" name="anak_ke" required>
                    </div>
                    <div class="col-md-3">
                        <label for="jumlah_saudara" class="form-label">Jumlah Saudara Kandung</label>
                        <input type="number" class="form-control" id="jumlah_saudara" name="jumlah_saudara" required>
                    </div>
                    <div class="col-md-6">
                        <label for="jenis_tinggal" class="form-label">Jenis Tinggal</label>
                        <input type="text" class="form-control" id="jenis_tinggal" name="jenis_tinggal" required>
                    </div>
                    <div class="col-md-6">
                        <label for="no_telp_rumah" class="form-label">No. Telp Rumah</label>
                        <input type="text" class="form-control" id="no_telp_rumah" name="no_telp_rumah">
                    </div>
                    <div class="col-md-6">
                        <label for="no_hp_wa" class="form-label">No. HP (WA)</label>
                        <input type="text" class="form-control" id="no_hp_wa" name="no_hp_wa" required>
                    </div>
                </div>

                {{-- Data Ayah Kandung --}}
                <h4 class="mt-5 mb-3 border-bottom pb-2">B. Data Ayah Kandung</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_ayah" class="form-label">Nama Ayah</label>
                        <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tahun_lahir_ayah" class="form-label">Tahun Lahir</label>
                        <input type="number" class="form-control" id="tahun_lahir_ayah" name="tahun_lahir_ayah" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nik_ayah" class="form-label">NIK Ayah</label>
                        <input type="text" class="form-control" id="nik_ayah" name="nik_ayah" inputmode="numeric" pattern="[0-9]*" required>
                    </div>
                    <div class="col-md-6">
                        <label for="pendidikan_ayah" class="form-label">Pendidikan Ayah</label>
                        <input type="text" class="form-control" id="pendidikan_ayah" name="pendidikan_ayah" required>
                    </div>
                    <div class="col-md-6">
                        <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                        <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah" required>
                    </div>
                    <div class="col-md-6">
                        <label for="penghasilan_ayah" class="form-label">Penghasilan Bulanan Ayah</label>
                        <input type="text" class="form-control" id="penghasilan_ayah" name="penghasilan_ayah" required>
                    </div>
                </div>

                {{-- Data Ibu Kandung --}}
                <h4 class="mt-5 mb-3 border-bottom pb-2">C. Data Ibu Kandung</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_ibu" class="form-label">Nama Ibu</label>
                        <input type="text" class="form-control" id="nama_ibu" name="nama_ibu" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tahun_lahir_ibu" class="form-label">Tahun Lahir</label>
                        <input type="number" class="form-control" id="tahun_lahir_ibu" name="tahun_lahir_ibu" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nik_ibu" class="form-label">NIK Ibu</label>
                        <input type="text" class="form-control" id="nik_ibu" name="nik_ibu" inputmode="numeric" pattern="[0-9]*" required>
                    </div>
                    <div class="col-md-6">
                        <label for="pendidikan_ibu" class="form-label">Pendidikan Ibu</label>
                        <input type="text" class="form-control" id="pendidikan_ibu" name="pendidikan_ibu" required>
                    </div>
                    <div class="col-md-6">
                        <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                        <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu" required>
                    </div>
                    <div class="col-md-6">
                        <label for="penghasilan_ibu" class="form-label">Penghasilan Bulanan Ibu</label>
                        <input type="text" class="form-control" id="penghasilan_ibu" name="penghasilan_ibu" required>
                    </div>
                </div>

                {{-- Data Wali --}}
                <h4 class="mt-5 mb-3 border-bottom pb-2">D. Data Wali (Opsional)</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nama_wali" class="form-label">Nama Wali</label>
                        <input type="text" class="form-control" id="nama_wali" name="nama_wali">
                    </div>
                    <div class="col-md-6">
                        <label for="tahun_lahir_wali" class="form-label">Tahun Lahir</label>
                        <input type="number" class="form-control" id="tahun_lahir_wali" name="tahun_lahir_wali">
                    </div>
                    <div class="col-md-6">
                        <label for="nik_wali" class="form-label">NIK Wali</label>
                        <input type="text" class="form-control" id="nik_wali" name="nik_wali" inputmode="numeric" pattern="[0-9]*">
                    </div>
                    <div class="col-md-6">
                        <label for="pendidikan_wali" class="form-label">Pendidikan Wali</label>
                        <input type="text" class="form-control" id="pendidikan_wali" name="pendidikan_wali">
                    </div>
                    <div class="col-md-6">
                        <label for="pekerjaan_wali" class="form-label">Pekerjaan Wali</label>
                        <input type="text" class="form-control" id="pekerjaan_wali" name="pekerjaan_wali">
                    </div>
                    <div class="col-md-6">
                        <label for="penghasilan_wali" class="form-label">Penghasilan Bulanan Wali</label>
                        <input type="text" class="form-control" id="penghasilan_wali" name="penghasilan_wali">
                    </div>
                </div>

                {{-- Data Periodik --}}
                <h4 class="mt-5 mb-3 border-bottom pb-2">E. Data Periodik</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="tinggi_badan" class="form-label">Tinggi Badan (cm)</label>
                        <input type="number" class="form-control" id="tinggi_badan" name="tinggi_badan" required>
                    </div>
                    <div class="col-md-6">
                        <label for="berat_badan" class="form-label">Berat Badan (kg)</label>
                        <input type="number" class="form-control" id="berat_badan" name="berat_badan" required>
                    </div>
                    <div class="col-md-6">
                        <label for="jarak_tempuh" class="form-label">Jarak Tempuh ke Sekolah (km)</label>
                        <input type="number" class="form-control" id="jarak_tempuh" name="jarak_tempuh" required>
                    </div>
                    <div class="col-md-6">
                        <label for="waktu_tempuh" class="form-label">Waktu Tempuh (menit)</label>
                        <input type="number" class="form-control" id="waktu_tempuh" name="waktu_tempuh" required>
                    </div>
                    <div class="col-md-6">
                        <label for="jumlah_saudara" class="form-label">Jumlah Saudara Kandung</label>
                        <input type="number" class="form-control" id="jumlah_saudara" name="jumlah_saudara" required>
                    </div>
                </div>

                {{-- Pilihan Jurusan --}}
                <h4 class="mt-5 mb-3 border-bottom pb-2">F. Pilihan Jurusan</h4>
                <div class="mb-3">
                    <label for="jurusan_id" class="form-label">Pilihan Jurusan</label>
                    <select class="form-select" id="jurusan_id" name="jurusan_id" required onchange="updateSlotInfo()">
                        <option value="">Pilih Jurusan</option>
                        @foreach ($jurusan as $j)
                            <option value="{{ $j->id }}" 
                                    data-slot="{{ $j->slot_tersisa }}"
                                    data-status="{{ $j->status_slot }}">
                                {{ $j->nama_jurusan }} (Slot: {{ $j->slot_tersisa }}/36)
                                @if ($j->status_slot === 'Penuh')
                                    - PENUH
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <small id="slot-info" class="form-text text-muted"></small>
                </div>

                <script>
                    function updateSlotInfo() {
                        const select = document.getElementById('jurusan_id');
                        const selectedOption = select.options[select.selectedIndex];
                        const slotInfo = document.getElementById('slot-info');
                        
                        if (selectedOption.value === '') {
                            slotInfo.textContent = '';
                            return;
                        }
                        
                        const slot = selectedOption.getAttribute('data-slot');
                        const status = selectedOption.getAttribute('data-status');
                        
                        if (status === 'Penuh') {
                            slotInfo.innerHTML = '<span class="badge bg-danger">Slot Penuh!</span>';
                            select.classList.add('is-invalid');
                        } else {
                            slotInfo.innerHTML = '<span class="badge bg-success">Slot Tersedia: ' + slot + '/36</span>';
                            select.classList.remove('is-invalid');
                        }
                    }
                </script>
                
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Tunggu hingga DOM sepenuhnya dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Validasi input untuk NISN, NIK, NPSN (hanya angka)
        const numericFields = ['nisn', 'nik', 'npsn_sekolah_asal', 'nik_ayah', 'nik_ibu', 'nik_wali'];
        
        numericFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                // Prevent non-numeric input on keypress
                field.addEventListener('keypress', function(e) {
                    const char = String.fromCharCode(e.which);
                    if (!/[0-9]/.test(char)) {
                        e.preventDefault();
                        return false;
                    }
                });
                
                // Prevent non-numeric input on keydown (untuk special characters)
                field.addEventListener('keydown', function(e) {
                    // Allow: backspace, delete, tab, escape, enter
                    if ([8, 9, 27, 13, 46].indexOf(e.keyCode) !== -1 ||
                        // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X, Cmd+A, Cmd+C, Cmd+V, Cmd+X
                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        (e.keyCode === 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                        (e.keyCode === 86 && (e.ctrlKey === true || e.metaKey === true)) ||
                        (e.keyCode === 88 && (e.ctrlKey === true || e.metaKey === true))) {
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                        return false;
                    }
                });
                
                // Prevent paste of non-numeric content
                field.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pastedText = (e.clipboardData || window.clipboardData).getData('text');
                    if (/^[0-9]*$/.test(pastedText)) {
                        this.value += pastedText;
                    } else {
                        alert('Hanya angka yang diperbolehkan untuk field ini');
                    }
                });
                
                // Clean up any non-numeric characters on input
                field.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }
        });
    });
</script>
</body>
</html>