<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #f8f9fa; }
        #wrapper { display: flex; }
        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -15rem;
            transition: margin .25s ease-out;
            background-color: #343a40;
            color: #fff;
        }
        #sidebar-wrapper .sidebar-heading { padding: 0.875rem 1.25rem; font-size: 1.2rem; }
        #sidebar-wrapper .list-group { width: 15rem; }
        #page-content-wrapper { min-width: 100vw; }
        #wrapper.toggled #sidebar-wrapper { margin-left: 0; }
        @media (min-width: 768px) {
            #sidebar-wrapper { margin-left: 0; }
            #page-content-wrapper { min-width: 0; width: 100%; }
            #wrapper.toggled #sidebar-wrapper { margin-left: -15rem; }
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <div id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 text-white">PPDB SMK Antartika</div>
            <div class="list-group list-group-flush">
                {{-- Navigasi Dinamis --}}
                @auth
                    @if(Auth::user()->role === 'ketua')
                        <a href="{{ route('ketua.dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                        <a href="{{ route('ketua.laporan.pdf') }}" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-chart-line me-2"></i>Laporan</a>
                        <a href="{{ route('ketua.backup') }}" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-database me-2"></i>Backup</a>
                    @endif

                    @if(Auth::user()->role === 'panitia')
                        <a href="{{ route('panitia.dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-home me-2"></i>Dashboard Panitia</a>
                        <a href="{{ route('panitia.input_form_number') }}" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-edit me-2"></i>Input Data</a>
                        <a href="{{ route('panitia.validasi.index') }}" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-check-circle me-2"></i>Validasi Data</a>
                        <a href="{{ route('panitia.cetak.formulir') }}" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-print me-2"></i>Cetak Formulir</a>
                    @endif

                    @if(Auth::user()->role === 'bendahara')
        <a href="{{ route('bendahara.dashboard.index') }}" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-home me-2"></i>Dashboard</a>
        <a href="{{ route('bendahara.pembayaran.belum_lunas') }}" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-money-check-alt me-2"></i>Manajemen Pembayaran</a>
        <a href="{{ route('bendahara.pembayaran.lunas') }}" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-check-circle me-2"></i>Pendaftar Lunas</a>
        <a href="{{ route('bendahara.pembayaran.refund_list') }}" class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-undo me-2"></i>Pendaftar Refund</a>
    @endif
                    
                   
                    {{-- Tombol Logout --}}
<a href="{{ route('logout') }}" class="list-group-item list-group-item-action bg-dark text-white">
    <i class="fas fa-sign-out-alt me-2"></i>Logout
</a>
                @endauth
            </div>
        </div>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle"><i class="fas fa-bars"></i></button>
                    <div class="ms-auto me-3">
                        @auth
                            <span class="navbar-text">
                                Halo, **{{ Auth::user()->name }}**!
                            </span>
                        @endauth
                    </div>
                </div>
            </nav>
            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("sidebarToggle").addEventListener("click", function(event) {
            event.preventDefault();
            document.getElementById("wrapper").classList.toggle("toggled");
        });
    </script>
</body>
</html>