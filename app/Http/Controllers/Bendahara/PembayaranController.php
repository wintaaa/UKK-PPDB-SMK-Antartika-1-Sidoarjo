<?php

namespace App\Http\Controllers\Bendahara;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftar;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    /**
     * Menampilkan dashboard utama bendahara dengan ringkasan statistik.
     */
    public function index()
{
    $belumLunas = Pendaftar::where('status_validasi', 'lolos_validasi')
                           ->where('status_pembayaran', 'belum_lunas')
                           ->count();

    $lunas = Pendaftar::where('status_validasi', 'lolos_validasi')
                      ->where('status_pembayaran', 'lunas')
                      ->count();

    $refund = Pendaftar::where('status_validasi', 'lolos_validasi')
                       ->where('status_pembayaran', 'refund')
                       ->count();

    return view('bendahara.dashboard.index', compact('belumLunas', 'lunas', 'refund'));
}

    /**
     * Menampilkan daftar pendaftar yang belum melunasi pembayaran.
     */
    public function showBelumLunas()
    {
        $pendaftar = Pendaftar::where('status_validasi', 'lolos_validasi')
                             ->where('status_pembayaran', 'belum_lunas')
                             ->with('siswa')
                             ->get();
                             
        return view('bendahara.pembayaran.belum_lunas', compact('pendaftar'));
    }

    /**
     * Menampilkan daftar pendaftar yang sudah lunas.
     */
    public function showLunas()
    {
        $pendaftar = Pendaftar::where('status_validasi', 'lolos_validasi')
                             ->where('status_pembayaran', 'lunas')
                             ->with('siswa')
                             ->get();
                             
        return view('bendahara.pembayaran.lunas', compact('pendaftar'));
    }

    /**
     * Menampilkan daftar pendaftar yang sudah di-refund.
     */
    public function showRefund()
    {
        $pendaftar = Pendaftar::where('status_pembayaran', 'refund')
                             ->with('siswa')
                             ->get();

        return view('bendahara.pembayaran.refund_list', compact('pendaftar'));
    }

    /**
     * Menampilkan detail pendaftar dan formulir pembayaran.
     */
    public function show($id)
    {
        $pendaftar = Pendaftar::with('siswa')->findOrFail($id);
        
        if ($pendaftar->status_validasi !== 'lolos_validasi' || $pendaftar->status_pembayaran !== 'belum_lunas') {
            return redirect()->route('bendahara.dashboard.index')
                             ->with('error', 'Halaman tidak dapat diakses.');
        }

        return view('bendahara.pembayaran.show', compact('pendaftar'));
    }

    /**
     * Memproses pembayaran pendaftar.
     */
    public function prosesPembayaran(Request $request, $id)
    {
        $request->validate([
            'jumlah_pembayaran' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();
            $pendaftar = Pendaftar::with('siswa')->findOrFail($id);
            if ($pendaftar->status_pembayaran === 'lunas') {
                DB::rollBack();
                return back()->with('error', 'Pembayaran sudah lunas sebelumnya.');
            }
            $pendaftar->update([
                'status_pembayaran' => 'lunas',
            ]);
            DB::commit();
            return redirect()->route('bendahara.dashboard.index')->with('success', 'Pembayaran untuk ' . $pendaftar->siswa->nama_siswa . ' berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal memproses pembayaran: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Mencetak kwitansi pembayaran pendaftar.
     */
    public function cetakKwitansi($id)
    {
        $pendaftar = Pendaftar::with('siswa')->findOrFail($id);
        if ($pendaftar->status_pembayaran !== 'lunas') {
            return back()->with('error', 'Pembayaran belum lunas, tidak bisa mencetak kwitansi.');
        }
        $data = [
            'pendaftar' => $pendaftar,
            'tanggal_cetak' => now()->format('d F Y'),
        ];
        $pdf = PDF::loadView('bendahara.pembayaran.kwitansi', $data);
        return $pdf->download('kwitansi-' . $pendaftar->no_formulir . '.pdf');
    }

    /**
     * Memproses pengembalian dana (refund).
     */
    public function prosesRefund($id)
    {
        try {
            DB::beginTransaction();
            $pendaftar = Pendaftar::findOrFail($id);
            
            if ($pendaftar->status_pembayaran !== 'lunas') {
                DB::rollBack();
                return back()->with('error', 'Pendaftar tidak bisa di-refund karena belum lunas.');
            }

            $pendaftar->update([
                'status_pembayaran' => 'refund',
            ]);
            
            DB::commit();
            return redirect()->route('bendahara.dashboard.index')->with('success', 'Pengembalian dana untuk ' . $pendaftar->siswa->nama_siswa . ' berhasil dicatat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses refund: ' . $e->getMessage());
        }
    }
}