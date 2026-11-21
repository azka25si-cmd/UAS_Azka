@extends('layouts.app')

@section('title', 'Detail Kamar {{ $kamar->no_kamar }}')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Kamar {{ $kamar->no_kamar }}</h2>
        <a href="{{ route('kamars.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $kamar->tipe_kamar }}</h5>
            <p class="card-text">
                <strong>Nomor Kamar:</strong> {{ $kamar->no_kamar }}<br>
                <strong>Harga per Malam:</strong> Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}<br>
                <strong>Status:</strong> 
                <span class="badge bg-{{ $kamar->status_kamar === 'tersedia' ? 'success' : 'danger' }}">
                    {{ ucfirst($kamar->status_kamar) }}
                </span>
            </p>

            @if($kamar->status_kamar === 'tersedia')
                <a href="{{ route('reservasi.create', $kamar->id_kamar) }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-calendar-plus"></i> Pesan Kamar Ini
                </a>
            @else
                <button class="btn btn-secondary btn-lg" disabled>Kamar Tidak Tersedia</button>
            @endif
        </div>
    </div>
</div>
@endsection