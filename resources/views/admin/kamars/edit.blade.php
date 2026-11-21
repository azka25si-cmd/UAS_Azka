@extends('layouts.app')

@section('title', 'Edit Kamar')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Kamar</h2>
        <a href="{{ route('admin.kamars.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.kamars.update', $kamar->id_kamar) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nomor Kamar</label>
                        <input type="text" name="no_kamar" class="form-control @error('no_kamar') is-invalid @enderror" value="{{ old('no_kamar', $kamar->no_kamar) }}" required>
                        @error('no_kamar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tipe Kamar</label>
                        <select name="tipe_kamar" class="form-select" required>
                            <option value="Standard" {{ old('tipe_kamar', $kamar->tipe_kamar) === 'Standard' ? 'selected' : '' }}>Standard</option>
                            <option value="Deluxe" {{ old('tipe_kamar', $kamar->tipe_kamar) === 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                            <option value="Suite" {{ old('tipe_kamar', $kamar->tipe_kamar) === 'Suite' ? 'selected' : '' }}>Suite</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Harga per Malam</label>
                        <input type="number" name="harga_per_malam" class="form-control @error('harga_per_malam') is-invalid @enderror" value="{{ old('harga_per_malam', $kamar->harga_per_malam) }}" required>
                        @error('harga_per_malam') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status Kamar</label>
                        <select name="status_kamar" class="form-select" required>
                            <option value="tersedia" {{ old('status_kamar', $kamar->status_kamar) === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="terisi" {{ old('status_kamar', $kamar->status_kamar) === 'terisi' ? 'selected' : '' }}>Terisi</option>
                            <option value="perawatan" {{ old('status_kamar', $kamar->status_kamar) === 'perawatan' ? 'selected' : '' }}>Perawatan</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Kamar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection