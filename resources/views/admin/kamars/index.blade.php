@extends('layouts.app')

@section('title', 'Kelola Kamar')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Kelola Kamar</h2>
        <a href="{{ route('admin.kamars.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Tambah Kamar
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>No Kamar</th>
                        <th>Tipe</th>
                        <th>Harga/Malam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kamars as $index => $kamar)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kamar->no_kamar }}</td>
                            <td>{{ $kamar->tipe_kamar }}</td>
                            <td>Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $kamar->status_kamar === 'tersedia' ? 'success' : 'danger' }}">
                                    {{ ucfirst($kamar->status_kamar) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.kamars.edit', $kamar->id_kamar) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.kamars.destroy', $kamar->id_kamar) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kamar ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection