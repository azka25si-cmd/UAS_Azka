@extends('layouts.app')

@section('title', 'Pesan Kamar')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Form Pemesanan Kamar</h2>
        <a href="{{ route('kamars.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('reservasi.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_kamar" value="{{ $kamar->id_kamar }}">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Check-in</label>
                        <input type="date" name="tgl_checkin" class="form-control @error('tgl_checkin') is-invalid @enderror" value="{{ old('tgl_checkin') }}" required>
                        @error('tgl_checkin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Check-out</label>
                        <input type="date" name="tgl_checkout" class="form-control @error('tgl_checkout') is-invalid @enderror" value="{{ old('tgl_checkout') }}" required>
                        @error('tgl_checkout') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fasilitas Tambahan (Opsional)</label>
                        <textarea name="fasilitas_tambahan" class="form-control" rows="3" placeholder="Contoh: Extra bed, makanan tambahan">{{ old('fasilitas_tambahan') }}</textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <p><strong>Kamar:</strong> {{ $kamar->no_kamar }} ({{ $kamar->tipe_kamar }})</p>
                    <p><strong>Harga:</strong> Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }} / malam</p>
                    <button type="submit" class="btn btn-success btn-lg w-100">
                        <i class="bi bi-calendar-check"></i> Buat Reservasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection