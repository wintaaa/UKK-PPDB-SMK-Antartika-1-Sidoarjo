<?php

namespace App\Http\Controllers\Ketua;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pendaftar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use PDF; // Tambahkan baris ini

class DashboardController extends Controller
{
    /**
     * Pastikan hanya user dengan role 'ketua' yang bisa mengakses controller ini.
     */
    public function __construct()
    {
        if (Auth::check() && Auth::user()->role !== 'ketua') {
            abort(403, 'Akses ditolak.');
        }
    }
    
    /**
     * Menampilkan dashboard dengan data statistik.
     */
    public function index()
    {
        // Menghitung jumlah total pendaftar
        $totalPendaftar = Pendaftar::count();
        
        // Menghitung jumlah formulir berdasarkan status
        $formulirKeluar = Pendaftar::where('status_formulir', 'keluar')->count();
        $formulirKembali = Pendaftar::where('status_formulir', 'kembali')->count();
        
        // Menghitung jumlah pendaftar yang lolos validasi dan pembayaran lunas
        $pendaftarLolos = Pendaftar::where('status_validasi', 'lolos_validasi')->count();
        $pembayaranLunas = Pendaftar::where('status_pembayaran', 'lunas')->count();
        
        // Mengambil statistik pendaftar per jurusan
        $statistikJurusan = Pendaftar::join('siswa', 'pendaftar.id', '=', 'siswa.pendaftar_id')
                                   ->select(DB::raw('pilihan_jurusan, count(*) as total'))
                                   ->groupBy('pilihan_jurusan')
                                   ->get();

        return view('ketua.dashboard.index', compact('totalPendaftar', 'formulirKeluar', 'formulirKembali', 'pendaftarLolos', 'pembayaranLunas', 'statistikJurusan'));
    }

    /**
     * Mengekspor data pendaftar ke file PDF.
     */
    public function exportPdf()
    {
        $pendaftar = Pendaftar::with(['siswa', 'dataOrangTua', 'dataWali'])->get();

        $pdf = PDF::loadView('ketua.laporan.pdf', compact('pendaftar'));

        return $pdf->download('Laporan_PPDB_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Melakukan backup database dan mengunduhnya.
     */
    public function backupData()
    {
        try {
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');
            $port = config('database.connections.mysql.port');

            // Cek apakah direktori backup sudah ada, jika tidak, buat
            if (!Storage::exists('backups')) {
                Storage::makeDirectory('backups');
            }

            $filename = "backup_" . date('Y-m-d_H-i-s') . ".sql";
            $path = storage_path('app/backups/' . $filename);
            
            // Perintah mysqldump
            $command = "mysqldump --user={$username} --password={$password} --host={$host} --port={$port} {$database} > {$path}";

            $process = Process::fromShellCommandline($command);
            $process->run();

            if (!$process->isSuccessful()) {
                throw new \RuntimeException($process->getErrorOutput());
            }

            return response()->download($path)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal melakukan backup database: ' . $e->getMessage());
        }
    }
}