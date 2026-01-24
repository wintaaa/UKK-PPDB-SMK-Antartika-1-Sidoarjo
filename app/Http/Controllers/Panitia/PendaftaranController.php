<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftar;
use App\Models\Siswa;
use App\Models\DataOrangTua;
use App\Models\DataWali;
use App\Models\Jurusan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    /**
     * Menampilkan formulir pengisian data siswa, orang tua, dan wali.
     */
    public function create($no_formulir)
    {
        $pendaftar = Pendaftar::where('no_formulir', $no_formulir)->firstOrFail();
        
        // Ambil data jurusan dari database dengan info slot tersisa dan harga
        $jurusan = Jurusan::all()->map(function($j) {
            return (object)[
                'id' => $j->id,
                'nama_jurusan' => $j->nama_jurusan,
                'slot_tersisa' => $j->getAvailableSlots(),
                'status_slot' => $j->hasAvailableSlot() ? 'Tersedia' : 'Penuh',
                'biaya_pendaftaran' => $j->biaya_pendaftaran,
            ];
        });

        return view('panitia.formulir.create', compact('pendaftar', 'jurusan'));
    }

    /**
     * Menyimpan data dari formulir ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Validasi untuk data siswa
            'no_formulir' => 'required|string|exists:pendaftar,no_formulir',
            'nama_siswa' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nisn' => 'required|digits:10|unique:siswa,nisn',
            'nik' => 'required|digits:16|unique:siswa,nik',
            'npsn_sekolah_asal' => 'required|digits_between:7,10',
            'nama_sekolah_asal' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'alamat' => 'required|string',
            'dusun' => 'nullable|string',
            'rt_rw' => 'nullable|string',
            'kecamatan' => 'required|string',
            'desa_kelurahan' => 'required|string',
            'kabupaten_kota' => 'required|string',
            'alat_transportasi' => 'required|string',
            'anak_ke' => 'required|integer',
            'jumlah_saudara' => 'required|integer',
            'jenis_tinggal' => 'required|string',
            'no_telp_rumah' => 'nullable|string',
            'no_hp_wa' => 'required|string',
            'tinggi_badan' => 'required|numeric',
            'berat_badan' => 'required|numeric',
            'jarak_tempuh' => 'required|numeric',
            'waktu_tempuh' => 'required|integer',
            'jurusan_id' => 'required|integer|exists:jurusan,id',
            
            // Validasi untuk data orang tua
            'nama_ayah' => 'required|string',
            'tahun_lahir_ayah' => 'required|integer',
            'nik_ayah' => 'required|string|numeric|unique:data_orang_tua,nik_ayah',
            'pendidikan_ayah' => 'required|string',
            'pekerjaan_ayah' => 'required|string',
            'penghasilan_ayah' => 'required|string',
            'nama_ibu' => 'required|string',
            'tahun_lahir_ibu' => 'required|integer',
            'nik_ibu' => 'required|string|numeric|unique:data_orang_tua,nik_ibu',
            'pendidikan_ibu' => 'required|string',
            'pekerjaan_ibu' => 'required|string',
            'penghasilan_ibu' => 'required|string',

            // Validasi untuk data wali (opsional)
            'nama_wali' => 'nullable|string',
            'tahun_lahir_wali' => 'nullable|integer',
            'nik_wali' => 'nullable|string|numeric|unique:data_wali,nik_wali',
            'pendidikan_wali' => 'nullable|string',
            'pekerjaan_wali' => 'nullable|string',
            'penghasilan_wali' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();
            
            $pendaftar = Pendaftar::where('no_formulir', $request->no_formulir)->firstOrFail();

            // Cek apakah jurusan masih memiliki slot
            $jurusanData = Jurusan::findOrFail($request->jurusan_id);
            
            if (!$jurusanData->hasAvailableSlot()) {
                return back()->withInput()->withErrors(['jurusan_id' => 'Slot untuk jurusan ' . $jurusanData->nama_jurusan . ' sudah penuh. Silakan pilih jurusan lain.']);
            }

            $namaJurusan = $jurusanData->nama_jurusan;

            Siswa::create(array_merge($request->only([
                'nama_siswa', 'jenis_kelamin', 'nisn', 'nik', 'npsn_sekolah_asal', 
                'nama_sekolah_asal', 'tempat_lahir', 'tanggal_lahir', 'agama', 
                'alamat', 'dusun', 'rt_rw', 'kecamatan', 'desa_kelurahan', 'kabupaten_kota', 
                'alat_transportasi', 'anak_ke', 'jumlah_saudara', 'jenis_tinggal', 
                'no_telp_rumah', 'no_hp_wa', 'tinggi_badan', 'berat_badan', 
                'jarak_tempuh', 'waktu_tempuh',
            ]), [
                'pendaftar_id' => $pendaftar->id,
                'pilihan_jurusan' => $namaJurusan,
                'ijazah_smp' => false,
                'kk' => false,
                'akta_kelahiran' => false,
                'foto' => false,
            ]));

            // Kurangi slot jurusan yang tersedia
            $jurusanData->increment('terdaftar');

            DataOrangTua::create(array_merge($request->only([
                'nama_ayah', 'tahun_lahir_ayah', 'nik_ayah', 'pendidikan_ayah', 
                'pekerjaan_ayah', 'penghasilan_ayah', 'nama_ibu', 'tahun_lahir_ibu', 
                'nik_ibu', 'pendidikan_ibu', 'pekerjaan_ibu', 'penghasilan_ibu',
            ]), [
                'pendaftar_id' => $pendaftar->id,
            ]));

            if ($request->filled('nama_wali')) {
                DataWali::create(array_merge($request->only([
                    'nama_wali', 'tahun_lahir_wali', 'nik_wali', 'pendidikan_wali', 
                    'pekerjaan_wali', 'penghasilan_wali',
                ]), [
                    'pendaftar_id' => $pendaftar->id,
                ]));
            }

            // Perbarui status pendaftar dengan biaya jurusan
            $pendaftar->update([
                'status_formulir' => 'sudah_kembali',
                'status_validasi' => 'belum_validasi',
                'status_pembayaran' => 'belum_lunas',
                'biaya_jurusan' => $jurusanData->biaya_pendaftaran,
                'sisa_pembayaran' => $jurusanData->biaya_pendaftaran,
            ]);

            DB::commit();

            // Mengarahkan kembali ke halaman daftar pendaftar
           return redirect()->route('panitia.dashboard')
                             ->with('success', 'Data pendaftar berhasil disimpan. Status formulir: Sudah Kembali.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

}