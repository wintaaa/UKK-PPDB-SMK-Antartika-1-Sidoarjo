<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Pendaftaran PPDB SMK Antartika 1 Sidoarjo</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11pt; margin: 20px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { font-size: 16pt; margin: 0; }
        .header p { margin: 0; font-size: 10pt; }
        .info-utama { margin-bottom: 20px; }
        .info-utama p { margin: 5px 0; }
        .info-utama .no-formulir { font-weight: bold; font-size: 14pt; }
        .data-section h2 { font-size: 12pt; background-color: #f0f0f0; padding: 5px; margin-top: 20px; margin-bottom: 10px; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .data-table td { padding: 5px; border-bottom: 1px dashed #ccc; }
        .data-table td:first-child { width: 30%; }
        .tandatangan { width: 100%; margin-top: 50px; }
        .tandatangan td { text-align: center; padding: 20px; vertical-align: top; }
        .tandatangan .nama { margin-top: 60px; border-bottom: 1px solid #000; padding-bottom: 5px; display: inline-block; }
        .checklist-dok { border: 1px solid #000; padding: 10px; margin-top: 20px; }
        .checklist-dok h3 { font-size: 11pt; margin-top: 0; }
        .checklist-dok label { display: block; margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>FORMULIR PENDAFTARAN PESERTA DIDIK BARU</h1>
        <p>SMK ANTARTIKA 1 SIDOARJO</p>
        <p>Jalan Raya Siwalanpanji No. 59, Buduran, Sidoarjo, Jawa Timur</p>
    </div>
    <div class="info-utama">
        <p>Tanggal Pendaftaran: {{ $tanggal_pendaftaran }}</p>
        <p class="no-formulir">Nomor Formulir: {{ $no_formulir }}</p>
    </div>
    <div class="data-section">
        <h2>A. DATA SISWA</h2>
        <table class="data-table">
            <tr><td>Nama</td><td>: .....................................................</td></tr>
            <tr><td>Jenis Kelamin</td><td>: .....................................................</td></tr>
            <tr><td>NISN</td><td>: .....................................................</td></tr>
            <tr><td>NIK</td><td>: .....................................................</td></tr>
            <tr><td>NPSN Sekolah Asal</td><td>: .....................................................</td></tr>
            <tr><td>Nama Sekolah Asal</td><td>: .....................................................</td></tr>
            <tr><td>Tempat, Tanggal Lahir</td><td>: .....................................................</td></tr>
            <tr><td>Agama</td><td>: .....................................................</td></tr>
            <tr><td>Alamat</td><td>: .....................................................</td></tr>
            <tr><td>Dusun/RW</td><td>: .....................................................</td></tr>
            <tr><td>Kecamatan</td><td>: .....................................................</td></tr>
            <tr><td>Desa/Kelurahan</td><td>: .....................................................</td></tr>
            <tr><td>Kabupaten/Kota</td><td>: .....................................................</td></tr>
            <tr><td>Alat Transportasi</td><td>: .....................................................</td></tr>
            <tr><td>Anak ke-</td><td>: .... dari .... bersaudara</td></tr>
            <tr><td>Jenis Tinggal</td><td>: .....................................................</td></tr>
            <tr><td>No. Telp Rumah</td><td>: .....................................................</td></tr>
            <tr><td>No. HP (WA)</td><td>: .....................................................</td></tr>
        </table>
    </div>
    <div class="data-section">
        <h2>B. DATA ORANG TUA KANDUNG</h2>
        <table class="data-table">
            <tr><td>Nama Ayah</td><td>: .....................................................</td></tr>
            <tr><td>Tahun Lahir Ayah</td><td>: .....................................................</td></tr>
            <tr><td>NIK Ayah</td><td>: .....................................................</td></tr>
            <tr><td>Pendidikan Ayah</td><td>: .....................................................</td></tr>
            <tr><td>Pekerjaan Ayah</td><td>: .....................................................</td></tr>
            <tr><td>Penghasilan Bulanan Ayah</td><td>: .....................................................</td></tr>
            <tr><td>Nama Ibu</td><td>: .....................................................</td></tr>
            <tr><td>Tahun Lahir Ibu</td><td>: .....................................................</td></tr>
            <tr><td>NIK Ibu</td><td>: .....................................................</td></tr>
            <tr><td>Pendidikan Ibu</td><td>: .....................................................</td></tr>
            <tr><td>Pekerjaan Ibu</td><td>: .....................................................</td></tr>
            <tr><td>Penghasilan Bulanan Ibu</td><td>: .....................................................</td></tr>
        </table>
    </div>
    <div class="data-section">
        <h2>C. DATA WALI (jika ada)</h2>
        <table class="data-table">
            <tr><td>Nama Wali</td><td>: .....................................................</td></tr>
            <tr><td>Tahun Lahir Wali</td><td>: .....................................................</td></tr>
            <tr><td>NIK Wali</td><td>: .....................................................</td></tr>
            <tr><td>Pendidikan Wali</td><td>: .....................................................</td></tr>
            <tr><td>Pekerjaan Wali</td><td>: .....................................................</td></tr>
            <tr><td>Penghasilan Bulanan Wali</td><td>: .....................................................</td></tr>
        </table>
    </div>
    <div class="data-section">
        <h2>D. DATA PERIODIK</h2>
        <table class="data-table">
            <tr><td>Tinggi Badan</td><td>: ........ cm</td></tr>
            <tr><td>Berat Badan</td><td>: ........ kg</td></tr>
            <tr><td>Jarak Tempuh ke Sekolah</td><td>: ........ km</td></tr>
            <tr><td>Waktu Tempuh</td><td>: ........ menit</td></tr>
            <tr><td>Jumlah Saudara Kandung</td><td>: ........ orang</td></tr>
        </table>
    </div>
    <div class="data-section">
        <h2>E. PILIHAN JURUSAN</h2>
        <table class="data-table">
            <tr><td>Pilihan Jurusan</td><td>: .....................................................</td></tr>
        </table>
    </div>
    <div class="checklist-dok">
        <h3>Kelengkapan Dokumen (diisi Panitia)</h3>
        <input type="checkbox"> Ijazah SMP<br>
        <input type="checkbox"> KK<br>
        <input type="checkbox"> Akta Kelahiran<br>
        <input type="checkbox"> Foto<br>
    </div>
    <table class="tandatangan">
        <tr>
            <td>
                <p>Sidoarjo, ...........................</p>
                <p>Mengetahui Orang Tua/Wali</p>
                <br><br><br>
                <div class="nama">................................</div>
            </td>
            <td>
                <p>Pendaftar/Siswa</p>
                <br><br><br>
                <div class="nama">................................</div>
            </td>
        </tr>
    </table>
</body>
</html>

