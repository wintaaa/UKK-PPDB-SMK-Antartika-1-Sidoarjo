@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4">Input Nomor Formulir</h1>
    <p class="lead mb-4">Masukkan nomor formulir untuk memulai proses pengisian data.</p>
    
    <div class="card shadow-sm mx-auto" style="max-width: 400px;">
        <div class="card-header bg-primary text-white text-center">
            <h4>Input Nomor Formulir</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('panitia.redirect_to_form') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="no_formulir" class="form-label">Nomor Formulir</label>
                    <input type="text" class="form-control" id="no_formulir" name="no_formulir" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Lanjutkan</button>
            </form>
        </div>
    </div>
</div>
@endsection