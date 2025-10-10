@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Dashboard Bendahara</h2>

    <div class="row">
        {{-- Card Belum Lunas --}}
        <div class="col-md-4 mb-4">
            <div class="card bg-warning text-dark h-100 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase fw-bold">Belum Lunas</div>
                            <div class="h5 mb-0">{{ $belumLunas }}</div>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <a href="{{ route('bendahara.pembayaran.belum_lunas') }}" class="text-dark">Lihat Detail</a>
                    <i class="fas fa-arrow-circle-right text-dark"></i>
                </div>
            </div>
        </div>

        {{-- Card Lunas --}}
        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white h-100 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase fw-bold">Sudah Lunas</div>
                            <div class="h5 mb-0">{{ $lunas }}</div>
                        </div>
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <a href="{{ route('bendahara.pembayaran.lunas') }}" class="text-white">Lihat Detail</a>
                    <i class="fas fa-arrow-circle-right text-white"></i>
                </div>
            </div>
        </div>

        {{-- Card Refund --}}
        <div class="col-md-4 mb-4">
            <div class="card bg-danger text-white h-100 shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase fw-bold">Refund</div>
                            <div class="h5 mb-0">{{ $refund }}</div>
                        </div>
                        <i class="fas fa-undo-alt fa-2x"></i>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    {{-- PERBAIKAN DI BARIS INI --}}
                    <a href="{{ route('bendahara.pembayaran.refund_list') }}" class="text-white">Lihat Detail</a>
                    <i class="fas fa-arrow-circle-right text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection