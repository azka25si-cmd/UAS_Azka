@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid mt-4">
    <h2>Selamat Datang, Admin</h2>
    <p class="text-muted">Selamat datang di halaman manajemen Wisma Kita.</p>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Kamar Tersedia</h5>
                    <p class="card-text display-4">{{ $kamars->where('status_kamar', 'tersedia')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Reservasi</h5>
                    <p class="card-text display-4">{{ $reservasis->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Menunggu Pembayaran</h5>
                    <p class="card-text display-4">{{ $pembayarans->where('status_pembayaran', 'menunggu')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Pelanggan</h5>
                    <p class="card-text display-4">{{ $users->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Reservasi Terbaru</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pelanggan</th>
                                <th>Kamar</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservasis->take(5) as $index => $r)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $r->user->nama_lengkap }}</td>
                                    <td>{{ $r->kamar->no_kamar }}</td>
                                    <td>{{ $r->tgl_checkin }}</td>
                                    <td>{{ $r->tgl_checkout }}</td>
                                    <td>
                                        <span class="badge bg-{{ $r->status_reservasi === 'dikonfirmasi' ? 'success' : ($r->status_reservasi === 'menunggu' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($r->status_reservasi) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.reservasis.update', $r->id_reservasi) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection