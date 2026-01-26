@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mt-4">Riwayat Cicilan Pembayaran</h1>
            <p class="lead">{{ $pendaftar->siswa->nama_siswa }} ({{ $pendaftar->no_formulir }})</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <!-- Info Pembayaran Summary -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Ringkasan Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Biaya Jurusan:</strong><br>
                            <span class="badge bg-primary" style="font-size: 1rem;">
                                Rp {{ number_format($pendaftar->biaya_jurusan, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="col-md-3">
                            <strong>Sudah Terbayar:</strong><br>
                            <span class="badge bg-success" style="font-size: 1rem;">
                                Rp {{ number_format($pendaftar->calculateTotalTerbayar(), 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="col-md-3">
                            <strong>Sisa Pembayaran:</strong><br>
                            <span class="badge bg-warning text-dark" style="font-size: 1rem;">
                                Rp {{ number_format($pendaftar->calculateSisaPembayaran(), 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="col-md-3">
                            <strong>Status:</strong><br>
                            @if ($pendaftar->isSudahLunas())
                                <span class="badge bg-success" style="font-size: 1rem;">LUNAS</span>
                            @else
                                <span class="badge bg-warning text-dark" style="font-size: 1rem;">BELUM LUNAS</span>
                            @endif
                        </div>
                        @foreach($cicilanList as $cicilan) 
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($cicilan->tanggal_pembayaran)->format('d/m/Y H:i') }}</td>
                                <td>Rp {{ number_format($cicilan->jumlah_cicilan, 0, ',', '.') }}</td>
                                
                               <<td class="text-center">
                                    @if($cicilan->status == 'approved')
                                       <a href="{{ route('bendahara.cicilan.cetak', ['pendaftar' => $pendaftar->id, 'cicilan' => $cicilan->id]) }}" 
                                        class="btn btn-primary btn-sm" 
                                        target="_blank">
                                        <i class="fas fa-print"></i> Cetak
                                        </a>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Riwayat Cicilan -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Daftar Cicilan</h5>
                </div>
                <div class="card-body">
                    @if ($cicilanList->isEmpty())
                        <div class="alert alert-info">
                            Belum ada cicilan yang tercatat.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th width="10%">No.</th>
                                        <th width="25%">Tanggal Pembayaran</th>
                                        <th width="20%">Jumlah Cicilan</th>
                                        <th width="20%">Total Terbayar</th>
                                        <th width="20%">Sisa Bayar</th>
                                        <th width="5%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cicilanList as $index => $cicilan)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $cicilan->tanggal_pembayaran->format('d M Y H:i') }}</td>
                                            <td>
                                                <span class="badge bg-info">
                                                    Rp {{ number_format($cicilan->jumlah_cicilan, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong>
                                                    @php
                                                        $totalAprovedUntilIndex = $cicilanList->where('status', 'approved')->take($index + 1)->sum('jumlah_cicilan');
                                                    @endphp
                                                    Rp {{ number_format($totalAprovedUntilIndex, 0, ',', '.') }}
                                                </strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning text-dark">
                                                    @php
                                                        $sisaUntilIndex = max(0, $pendaftar->biaya_jurusan - $totalAprovedUntilIndex);
                                                    @endphp
                                                    Rp {{ number_format($sisaUntilIndex, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    @if ($cicilan->status === 'pending')
                                                        <form action="{{ route('bendahara.cicilan.approve', [$pendaftar->id, $cicilan->id]) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success" title="Setujui cicilan">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('bendahara.cicilan.reject', [$pendaftar->id, $cicilan->id]) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger" title="Tolak cicilan" onclick="return confirm('Yakin ingin menghapus cicilan ini?')">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    @elseif ($cicilan->status === 'approved')
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check"></i> Disetujui
                                                        </span>
                                                    @elseif ($cicilan->status === 'rejected')
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times"></i> Ditolak
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('bendahara.pembayaran.show', $pendaftar->id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Detail Pembayaran
                </a>
                @if (!$pendaftar->isSudahLunas())
                    <a href="{{ route('bendahara.cicilan.create', $pendaftar->id) }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Cicilan
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
