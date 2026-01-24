<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanPricingController extends Controller
{
    /**
     * Menampilkan daftar harga jurusan
     */
    public function index()
    {
        $jurusans = Jurusan::orderBy('nama_jurusan', 'asc')->get();
        return view('panitia.pricing.index', compact('jurusans'));
    }

    /**
     * Menampilkan form edit harga jurusan
     */
    public function edit(Jurusan $jurusan)
    {
        return view('panitia.pricing.edit', compact('jurusan'));
    }

    /**
     * Menyimpan update harga jurusan
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        $validated = $request->validate([
            'biaya_pendaftaran' => 'required|numeric|min:0',
        ], [
            'biaya_pendaftaran.required' => 'Biaya pendaftaran harus diisi',
            'biaya_pendaftaran.numeric' => 'Biaya pendaftaran harus berupa angka',
            'biaya_pendaftaran.min' => 'Biaya pendaftaran tidak boleh negatif',
        ]);

        $jurusan->update($validated);

        return redirect()->route('panitia.pricing.index')
            ->with('success', "Harga jurusan {$jurusan->nama_jurusan} berhasil diperbarui");
    }

    /**
     * Menampilkan form edit harga jurusan secara inline (AJAX)
     */
    public function editInline(Jurusan $jurusan)
    {
        return view('panitia.pricing.edit_inline', compact('jurusan'));
    }

    /**
     * Update harga jurusan via AJAX
     */
    public function updateInline(Request $request, Jurusan $jurusan)
    {
        $validated = $request->validate([
            'biaya_pendaftaran' => 'required|numeric|min:0',
        ]);

        $jurusan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Harga berhasil diperbarui',
            'biaya_pendaftaran' => number_format($jurusan->biaya_pendaftaran, 2, ',', '.'),
        ]);
    }
}
