
@extends('layouts.admin.app')

@section('title', 'Kelola Kamar')

@section('content')
<div class="container-fluid mt-4">

    {{-- Header halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Kelola Kamar</h2>
            <p class="text-muted mb-0">
                Kelola informasi dan ketersediaan kamar wisma.
            </p>
        </div>

        <a href="{{ route('admin.kamars.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i>
            Tambah Kamar
        </a>
    </div>

    {{-- Notifikasi berhasil --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
        </div>
    @endif

    {{-- Notifikasi gagal --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}

            <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
        </div>
    @endif

    {{-- Notifikasi validasi --}}
    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Ringkasan jumlah kamar --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="text-muted mb-1">Total Kamar</div>
                    <h3 class="mb-0">{{ $kamars->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="text-muted mb-1">Kamar Tersedia</div>
                    <h3 class="mb-0 text-success">
                        {{ $kamars->where('status_kamar', 'tersedia')->count() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="text-muted mb-1">Kamar Tidak Tersedia</div>
                    <h3 class="mb-0 text-danger">
                        {{ $kamars->where('status_kamar', '!=', 'tersedia')->count() }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel data kamar --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Daftar Kamar</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th width="60">No.</th>
                            <th>No. Kamar</th>
                            <th>Tipe Kamar</th>
                            <th>Harga per Malam</th>
                            <th>Status</th>
                            <th width="160">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        {{-- Kondisi jika belum ada data --}}
                        @if($kamars->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-door-closed fs-1 text-muted"></i>
                                    <p class="text-muted mt-2 mb-0">
                                        Belum ada data kamar.
                                    </p>
                                    <p class="text-muted small">
                                        Silakan tambahkan kamar baru.
                                    </p>
                                </td>
                            </tr>

                        @else

                            {{-- Menampilkan setiap kamar --}}
                            @foreach($kamars as $index => $kamar)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td>
                                        <strong>{{ $kamar->no_kamar }}</strong>
                                    </td>

                                    <td>{{ $kamar->tipe_kamar }}</td>

                                    <td>
                                        Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        @if($kamar->status_kamar === 'tersedia')
                                            <span class="badge bg-success">
                                                Tersedia
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                {{ ucfirst($kamar->status_kamar) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        {{-- Tombol edit --}}
                                        <a href="{{ route('admin.kamars.edit', $kamar->id_kamar) }}"
                                            class="btn btn-sm btn-warning"
                                            title="Edit kamar">
                                            <i class="bi bi-pencil-square"></i>
                                            Edit
                                        </a>

                                        {{-- Form hapus --}}
                                        <form
                                            action="{{ route('admin.kamars.destroy', $kamar->id_kamar) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Apakah kamu yakin ingin menghapus kamar {{ $kamar->no_kamar }}?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Hapus kamar">
                                                <i class="bi bi-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        @endif
                    </tbody>

                </table>
            </div>
        </div>

        <div class="card-footer bg-white text-muted small">
            Menampilkan {{ $kamars->count() }} data kamar.
        </div>
    </div>

</div>
@endsection
