@extends('layouts.app')

@section('title', 'Pembayaran Reservasi')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Pembayaran Reservasi</h2>
        <a href="{{ route('reservasi.show', $reservasi->id_reservasi) }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_reservasi" value="{{ $reservasi->id_reservasi }}">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Bayar</label>
                        <input type="date" name="tgl_bayar" class="form-control" value="{{ old('tgl_bayar', today()) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jumlah Bayar</label>
                        <input type="number" name="jumlah_bayar" class="form-control @error('jumlah_bayar') is-invalid @enderror" value="{{ old('jumlah_bayar', $reservasi->total_bayar) }}" required>
                        @error('jumlah_bayar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Bukti Transfer (Foto)</label>
                        <input type="file" name="bukti_transfer" class="form-control @error('bukti_transfer') is-invalid @enderror" accept="image/*" required>
                        @error('bukti_transfer') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted">Format: JPG, JPEG, PNG (maks. 2MB)</small>
                    </div>
                </div>

                <div class="mt-4">
                    <p><strong>Total yang harus dibayar:</strong> Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</p>
                    <button type="submit" class="btn btn-success btn-lg w-100">
                        <i class="bi bi-credit-card"></i> Upload Bukti Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection