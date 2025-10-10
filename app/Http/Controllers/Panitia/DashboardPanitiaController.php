<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use Illuminate\Http\Request;

class DashboardPanitiaController extends Controller
{
    /**
     * Menampilkan daftar semua pendaftar.
     */
    public function index()
    {
        // Mengambil semua data pendaftar dan memberinya nama variabel $daftarPendaftar
        $daftarPendaftar = Pendaftar::orderBy('created_at', 'asc')->get();

        // Menghitung jumlah pendaftar yang statusnya 'keluar'
        $formulirKeluar = Pendaftar::where('status_formulir', 'keluar')->count();

        // Menghitung jumlah pendaftar yang statusnya 'sudah_kembali'
        $formulirKembali = Pendaftar::where('status_formulir', 'sudah_kembali')->count();

        // Mengirimkan semua variabel ke tampilan (view)
        return view('panitia.dashboard', compact('daftarPendaftar', 'formulirKeluar', 'formulirKembali'));
    }

    /**
     * Menampilkan formulir untuk menginput nomor formulir.
     */
    public function showFormInput()
    {
        return view('panitia.input_form_number');
    }

    /**
     * Mengarahkan ke formulir pendaftaran berdasarkan nomor formulir.
     */
    public function redirectToForm(Request $request)
    {
        $validatedData = $request->validate([
            'no_formulir' => 'required|string|exists:pendaftar,no_formulir',
        ]);

        return redirect()->route('panitia.pendaftaran.create', ['no_formulir' => $validatedData['no_formulir']]);
    }
}