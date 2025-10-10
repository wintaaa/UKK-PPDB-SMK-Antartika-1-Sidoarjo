<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ValidasiController extends Controller
{
    /**
     * Menampilkan daftar pendaftar yang siap divalidasi.
     */
    public function index()
    {
        $pendaftar = Pendaftar::where('status_formulir', 'sudah_kembali')
                             ->with('siswa')
                             ->get();
        
        return view('panitia.validasi.index', compact('pendaftar'));
    }

    /**
     * Menampilkan detail pendaftar untuk divalidasi.
     */
    public function show($id)
    {
        $pendaftar = Pendaftar::with(['siswa', 'dataOrangTua', 'dataWali'])->findOrFail($id);
        return view('panitia.validasi.show', compact('pendaftar'));
    }

    /**
     * Memperbarui status validasi pendaftar.
     */
    public function update(Request $request, $id)
    {
        // PERBAIKAN: Mengubah aturan validasi agar sesuai dengan data
        $request->validate([
            'ijazah_smp' => 'nullable',
            'kk' => 'nullable',
            'akta_kelahiran' => 'nullable',
            'foto' => 'nullable',
            'status_validasi' => 'required|in:lolos_validasi,belum_lengkap,ditolak',
        ]);
        
        try {
            DB::beginTransaction();
            
            $pendaftar = Pendaftar::findOrFail($id);
            
            if ($pendaftar->siswa) {
                $pendaftar->siswa->update([
                    'ijazah_smp' => $request->boolean('ijazah_smp'),
                    'kk' => $request->boolean('kk'),
                    'akta_kelahiran' => $request->boolean('akta_kelahiran'),
                    'foto' => $request->boolean('foto'),
                ]);
            }
            
            $pendaftar->update([
                'status_validasi' => $request->status_validasi,
            ]);
            
            if ($request->status_validasi === 'lolos_validasi') {
                $pendaftar->update([
                    'status_pembayaran' => 'belum_lunas',
                ]);
            }

            DB::commit();

            return redirect()->route('panitia.validasi.index')
                             ->with('success', 'Status validasi berhasil diperbarui.');
                             
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui status validasi: ' . $e->getMessage()]);
        }
    }
}