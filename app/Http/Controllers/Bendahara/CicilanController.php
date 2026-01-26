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
        // 1. Validasi Input (Hapus 'numeric' agar tidak error saat ada titik/koma)
        $request->validate([
            'jumlah_cicilan' => 'required', 
            'keterangan' => 'nullable|string|max:255',
        ], [
            'jumlah_cicilan.required' => 'Jumlah cicilan harus diisi',
        ]);

        try {
            DB::beginTransaction();

            $pendaftar = Pendaftar::findOrFail($id);
            
            // 2. Bersihkan input agar menjadi angka murni (Contoh: 150.000 -> 150000)
            $nominalBersih = preg_replace('/[^0-9]/', '', $request->jumlah_cicilan);
            $jumlahCicilan = (int)$nominalBersih;

            if ($jumlahCicilan < 1) {
                return back()->withInput()->withErrors(['jumlah_cicilan' => 'Jumlah cicilan minimal Rp 1']);
            }

            // 3. Hitung total yang sudah APPROVED sebelumnya untuk validasi sisa
            $totalTerbayarSaatIni = CicilanPembayaran::where('pendaftar_id', $id)
                ->where('status', 'approved')
                ->sum('jumlah_cicilan');
                
            $sisaPembayaranSaatIni = $pendaftar->biaya_jurusan - $totalTerbayarSaatIni;

            // Validasi agar cicilan tidak lebih dari sisa
            if ($jumlahCicilan > $sisaPembayaranSaatIni) {
                DB::rollBack();
                return back()->withInput()->withErrors([
                    'jumlah_cicilan' => 'Jumlah tidak boleh melebihi sisa (Maks: Rp ' . number_format($sisaPembayaranSaatIni, 0, ',', '.') . ')'
                ]);
            }

            // 4. Simpan Cicilan dengan status 'approved' agar langsung memotong saldo
            CicilanPembayaran::create([
                'pendaftar_id' => $pendaftar->id,
                'jumlah_cicilan' => $jumlahCicilan,
                'tanggal_pembayaran' => now(),
                'keterangan' => $request->keterangan,
                'status' => 'approved', 
            ]);

            // 5. Update data Pendaftar (Gunakan query manual untuk menghindari loop/timeout)
            $totalTerbayarBaru = $totalTerbayarSaatIni + $jumlahCicilan;
            $sisaBayarBaru = $pendaftar->biaya_jurusan - $totalTerbayarBaru;
            $statusPembayaran = $sisaBayarBaru <= 0 ? 'lunas' : 'belum_lunas';

            $pendaftar->update([
                'total_terbayar' => $totalTerbayarBaru,
                'sisa_pembayaran' => $sisaBayarBaru,
                'status_pembayaran' => $statusPembayaran,
                'tanggal_pembayaran' => now(),
            ]);

            DB::commit();

            return redirect()->route('bendahara.pembayaran.show', $id)
                ->with('success', 'Cicilan Rp ' . number_format($jumlahCicilan, 0, ',', '.') . ' berhasil dicatat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal menyimpan: ' . $e->getMessage()]);
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
 public function cetakKwitansiCicilan($pendaftar_id, $cicilan_id)
{
    $pendaftar = Pendaftar::with('siswa')->findOrFail($pendaftar_id);
    $cicilanUtama = CicilanPembayaran::findOrFail($cicilan_id);

    // Ambil semua cicilan approved untuk riwayat di bawah kwitansi
    $riwayatCicilan = CicilanPembayaran::where('pendaftar_id', $pendaftar_id)
        ->where('status', 'approved')
        ->orderBy('tanggal_pembayaran', 'asc')
        ->get();

    $totalBayarHinggaKini = 0;
    foreach ($riwayatCicilan as $rc) {
        $totalBayarHinggaKini += $rc->jumlah_cicilan;
        if ($rc->id == $cicilan_id) break; 
    }

    $data = [
        'pendaftar' => $pendaftar,
        'cicilanUtama' => $cicilanUtama,
        'riwayatCicilan' => $riwayatCicilan,
        'sisaPembayaran' => $pendaftar->biaya_jurusan - $totalBayarHinggaKini,
        'tanggal_cetak' => now()->format('d F Y'),
    ];

    // Menggunakan library DomPDF (Barryvdh)
    $pdf = \PDF::loadView('bendahara.cicilan.kwitansi_pdf', $data);
    
    // Gunakan stream() agar membuka tab baru sebagai PDF, bukan HTML halaman web biasa
    return $pdf->stream('Kwitansi-' . $pendaftar->siswa->nama_siswa . '.pdf');
}
}