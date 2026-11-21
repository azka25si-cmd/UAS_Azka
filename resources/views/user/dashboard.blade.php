@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="container-fluid mt-4">
    <h2>Selamat Datang, {{ auth('web')->user()->nama_lengkap }}</h2>
    <p class="text-muted">Kelola reservasi kamar Anda di Wisma Kita.</p>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Reservasi Saya</h5>
                </div>
                <div class="card-body">
                    @if($reservasis->count() > 0)
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kamar</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Total Bayar</th>
                                    <th>Status Reservasi</th>
                                    <th>Status Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservasis as $index => $r)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $r->kamar->no_kamar }}</td>
                                        <td>{{ $r->tgl_checkin }}</td>
                                        <td>{{ $r->tgl_checkout }}</td>
                                        <td>Rp {{ number_format($r->total_bayar, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $r->status_reservasi === 'dikonfirmasi' ? 'success' : ($r->status_reservasi === 'menunggu' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($r->status_reservasi) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($r->pembayaran)
                                                <span class="badge bg-{{ $r->pembayaran->status_pembayaran === 'diterima' ? 'success' : ($r->pembayaran->status_pembayaran === 'ditolak' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($r->pembayaran->status_pembayaran) }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">Belum Bayar</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('reservasi.show', $r->id_reservasi) }}" class="btn btn-sm btn-info">Detail</a>
                                            @if($r->status_reservasi === 'menunggu' && !$r->pembayaran)
                                                <a href="{{ route('pembayaran.create', $r->id_reservasi) }}" class="btn btn-sm btn-primary">Bayar</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-calendar-x display-4 text-muted"></i>
                            <p class="mt-2">Anda belum memiliki reservasi.</p>
                            <a href="{{ route('kamars.index') }}" class="btn btn-primary">Pesan Kamar Sekarang</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection