<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\CicilanPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CicilanController extends Controller
{
    /**
     * Menampilkan form input cicilan pembayaran
     */
    public function create($id)
    {
        $pendaftar = Pendaftar::with('siswa', 'cicilanPembayaran')->findOrFail($id);

        if ($pendaftar->status_validasi !== 'lolos_validasi') {
            return redirect()->route('bendahara.dashboard.index')
                ->with('error', 'Pendaftar belum lolos validasi.');
        }

        return view('bendahara.cicilan.create', compact('pendaftar'));
    }

    /**
     * Menyimpan cicilan pembayaran
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'jumlah_cicilan' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'jumlah_cicilan.required' => 'Jumlah cicilan harus diisi',
            'jumlah_cicilan.numeric' => 'Jumlah cicilan harus berupa angka',
            'jumlah_cicilan.min' => 'Jumlah cicilan minimal Rp 1',
        ]);

        try {
            DB::beginTransaction();

            $pendaftar = Pendaftar::findOrFail($id);
            
            // Jika biaya jurusan belum tersimpan, ambil dari jurusan
            if ($pendaftar->biaya_jurusan == 0) {
                $siswa = $pendaftar->siswa;
                if ($siswa) {
                    $jurusan = \App\Models\Jurusan::where('nama_jurusan', $siswa->pilihan_jurusan)->first();
                    if ($jurusan) {
                        $pendaftar->update([
                            'biaya_jurusan' => $jurusan->biaya_pendaftaran,
                            'sisa_pembayaran' => $jurusan->biaya_pendaftaran - $pendaftar->total_terbayar,
                        ]);
                    }
                }
            }

            // Ambil input dari form, lalu buang semua karakter selain angka
            $nominalBersih = preg_replace('/[^0-9]/', '', $request->jumlah_cicilan);
            $jumlahCicilan = (int)$nominalBersih;
            $sisaPembayaran = $pendaftar->calculateSisaPembayaran();

            // Validasi jumlah cicilan tidak lebih dari sisa pembayaran
            if ($jumlahCicilan > $sisaPembayaran) {
                DB::rollBack();
                return back()->withInput()->withErrors([
                    'jumlah_cicilan' => 'Jumlah cicilan tidak boleh lebih dari sisa pembayaran (Rp ' . number_format($sisaPembayaran, 0, ',', '.') . ')'
                ]);
            }

            // Simpan cicilan
            CicilanPembayaran::create([
                'pendaftar_id' => $pendaftar->id,
                'jumlah_cicilan' => $jumlahCicilan,
                'tanggal_pembayaran' => now(),
                'keterangan' => $request->keterangan,
                'status' => 'pending',
            ]);

            // Refresh model untuk mendapatkan data terbaru dari database
            $pendaftar->refresh();

            // Update total terbayar dan sisa pembayaran di pendaftar
            $totalTerbayar = $pendaftar->calculateTotalTerbayar();
            $sisaBayar = $pendaftar->calculateSisaPembayaran();

            // Tentukan status pembayaran
            $statusPembayaran = $totalTerbayar >= $pendaftar->biaya_jurusan ? 'lunas' : 'belum_lunas';

            $pendaftar->update([
                'total_terbayar' => $totalTerbayar,
                'sisa_pembayaran' => $sisaBayar,
                'status_pembayaran' => $statusPembayaran,
                'tanggal_pembayaran' => now(),
            ]);

            DB::commit();

            $pesan = 'Cicilan Rp ' . number_format($jumlahCicilan, 0, ',', '.') . ' berhasil dicatat';
            if ($totalTerbayar >= $pendaftar->biaya_jurusan) {
                $pesan .= '. Pembayaran sudah LUNAS!';
            }

            return redirect()->route('bendahara.pembayaran.show', $id)
                ->with('success', $pesan);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan cicilan: ' . $e->getMessage()]);
        }
    }

    /**
     * Menampilkan riwayat cicilan
     */
    public function history($id)
    {
        $pendaftar = Pendaftar::with('siswa', 'cicilanPembayaran')->findOrFail($id);
        
        if ($pendaftar->status_validasi !== 'lolos_validasi') {
            return redirect()->route('bendahara.dashboard.index')
                ->with('error', 'Pendaftar belum lolos validasi.');
        }

        // Refresh untuk mendapatkan data terbaru dari database
        $pendaftar->refresh();

        $cicilanList = $pendaftar->cicilanPembayaran()->orderBy('tanggal_pembayaran', 'asc')->get();

        return view('bendahara.cicilan.history', compact('pendaftar', 'cicilanList'));
    }

    /**
     * Approve/Verifikasi cicilan pembayaran
     */
    public function approveCicilan($id, $cicilanId)
    {
        try {
            DB::beginTransaction();
            
            $cicilan = CicilanPembayaran::findOrFail($cicilanId);
            $pendaftar = Pendaftar::findOrFail($id);
            
            if ($cicilan->pendaftar_id != $id) {
                DB::rollBack();
                return back()->with('error', 'Data cicilan tidak valid.');
            }
            
            $cicilan->update(['status' => 'approved']);
            
            // Recalculate total terbayar dan sisa pembayaran
            $totalTerbayar = $pendaftar->calculateTotalTerbayar();
            $sisaBayar = $pendaftar->calculateSisaPembayaran();
            
            // Tentukan status pembayaran
            $statusPembayaran = $totalTerbayar >= $pendaftar->biaya_jurusan ? 'lunas' : 'belum_lunas';
            
            $pendaftar->update([
                'total_terbayar' => $totalTerbayar,
                'sisa_pembayaran' => $sisaBayar,
                'status_pembayaran' => $statusPembayaran,
            ]);
            
            DB::commit();
            return back()->with('success', 'Cicilan berhasil disetujui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyetujui cicilan: ' . $e->getMessage());
        }
    }

    /**
     * Reject/Hapus cicilan pembayaran
     */
    public function rejectCicilan($id, $cicilanId)
    {
        try {
            DB::beginTransaction();
            
            $pendaftar = Pendaftar::findOrFail($id);
            $cicilan = CicilanPembayaran::findOrFail($cicilanId);
            
            if ($cicilan->pendaftar_id != $id) {
                DB::rollBack();
                return back()->with('error', 'Data cicilan tidak valid.');
            }
            
            // Simpan jumlah cicilan sebelum dihapus
            $jumlahCicilan = $cicilan->jumlah_cicilan;
            
            // Hapus cicilan
            $cicilan->delete();
            
            // Recalculate total terbayar dan sisa pembayaran
            $totalTerbayar = $pendaftar->calculateTotalTerbayar();
            $sisaBayar = $pendaftar->calculateSisaPembayaran();
            
            // Tentukan status pembayaran
            $statusPembayaran = $totalTerbayar >= $pendaftar->biaya_jurusan ? 'lunas' : 'belum_lunas';
            
            $pendaftar->update([
                'total_terbayar' => $totalTerbayar,
                'sisa_pembayaran' => $sisaBayar,
                'status_pembayaran' => $statusPembayaran,
            ]);
            
            DB::commit();
            return back()->with('success', 'Cicilan berhasil dihapus dan data pembayaran diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus cicilan: ' . $e->getMessage());
        }
    }
}
