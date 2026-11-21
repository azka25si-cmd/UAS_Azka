@extends('layouts.app')

@section('title', 'Edit Reservasi')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Reservasi</h2>
        <a href="{{ route('reservasi.show', $reservasi->id_reservasi) }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('reservasi.update', $reservasi->id_reservasi) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Check-in</label>
                        <input type="date" name="tgl_checkin" class="form-control @error('tgl_checkin') is-invalid @enderror" value="{{ old('tgl_checkin', $reservasi->tgl_checkin) }}" required>
                        @error('tgl_checkin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Check-out</label>
                        <input type="date" name="tgl_checkout" class="form-control @error('tgl_checkout') is-invalid @enderror" value="{{ old('tgl_checkout', $reservasi->tgl_checkout) }}" required>
                        @error('tgl_checkout') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fasilitas Tambahan</label>
                        <textarea name="fasilitas_tambahan" class="form-control" rows="3">{{ old('fasilitas_tambahan', $reservasi->fasilitas_tambahan) }}</textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Reservasi</button>
                    <a href="{{ route('reservasi.show', $reservasi->id_reservasi) }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection