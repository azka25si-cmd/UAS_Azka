@extends('layouts.app')

@section('title', 'Tambah Kamar')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Tambah Kamar Baru</h2>
        <a href="{{ route('admin.kamars.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.kamars.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nomor Kamar</label>
                        <input type="text" name="no_kamar" class="form-control @error('no_kamar') is-invalid @enderror" value="{{ old('no_kamar') }}" placeholder="Contoh: 101" required>
                        @error('no_kamar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tipe Kamar</label>
                        <select name="tipe_kamar" class="form-select" required>
                            <option value="Standard">Standard</option>
                            <option value="Deluxe">Deluxe</option>
                            <option value="Suite">Suite</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Harga per Malam</label>
                        <input type="number" name="harga_per_malam" class="form-control @error('harga_per_malam') is-invalid @enderror" value="{{ old('harga_per_malam') }}" placeholder="Contoh: 150000" required>
                        @error('harga_per_malam') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status Kamar</label>
                        <select name="status_kamar" class="form-select" required>
                            <option value="tersedia">Tersedia</option>
                            <option value="terisi">Terisi</option>
                            <option value="perawatan">Perawatan</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Kamar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection