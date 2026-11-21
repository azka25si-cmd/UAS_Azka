@extends('layouts.app')

@section('title', 'Daftar Kamar')

@section('content')
<div class="container-fluid mt-4">
    <h2>Kamar Tersedia</h2>
    <a href="{{ route('user.dashboard') }}" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($kamars as $kamar)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Kamar {{ $kamar->no_kamar }}</h5>
                        <p class="card-text">
                            <strong>Tipe:</strong> {{ $kamar->tipe_kamar }}<br>
                            <strong>Harga:</strong> Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }} / malam<br>
                            <strong>Status:</strong> 
                            <span class="badge bg-{{ $kamar->status_kamar === 'tersedia' ? 'success' : 'danger' }}">
                                {{ ucfirst($kamar->status_kamar) }}
                            </span>
                        </p>
                        @if($kamar->status_kamar === 'tersedia')
                            <a href="{{ route('reservasi.create', $kamar->id_kamar) }}" class="btn btn-primary w-100">Pesan Sekarang</a>
                        @else
                            <button class="btn btn-secondary w-100" disabled>Tidak Tersedia</button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection