@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="container-fluid mt-4">

    {{-- HEADER DASHBOARD --}}
    <div class="mb-4">
        <h2>Selamat Datang, {{ auth('web')->user()->nama_lengkap }}</h2>
        <p class="text-muted">
            Kelola reservasi kamar Anda di Wisma Kita.
        </p>
    </div>

    {{-- TABEL RESERVASI --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">

                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Reservasi Saya</h5>
                </div>

                <div class="card-body">

                    @if($reservasis->count() > 0)

                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle">

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

                                        @php
                                            $pembayaran = $r->pembayarans
                                                ->sortByDesc('created_at')
                                                ->first();
                                        @endphp

                                        <tr>
                                            {{-- NOMOR --}}
                                            <td>{{ $index + 1 }}</td>

                                            {{-- KAMAR --}}
                                            <td>
                                                {{ $r->kamar->no_kamar ?? '-' }}
                                            </td>

                                            {{-- TANGGAL --}}
                                            <td>
                                                {{ $r->tgl_checkin->format('d-m-Y') }}
                                            </td>

                                            <td>
                                                {{ $r->tgl_checkout->format('d-m-Y') }}
                                            </td>

                                            {{-- TOTAL BAYAR --}}
                                            <td>
                                                Rp {{ number_format($r->total_bayar, 0, ',', '.') }}
                                            </td>

                                            {{-- STATUS RESERVASI --}}
                                            <td>
                                                @if($r->status_reservasi === 'dikonfirmasi')
                                                    <span class="badge bg-success">
                                                        Dikonfirmasi
                                                    </span>
                                                @elseif($r->status_reservasi === 'menunggu')
                                                    <span class="badge bg-warning text-dark">
                                                        Menunggu
                                                    </span>
                                                @elseif($r->status_reservasi === 'dibatalkan')
                                                    <span class="badge bg-danger">
                                                        Dibatalkan
                                                    </span>
                                                @elseif($r->status_reservasi === 'selesai')
                                                    <span class="badge bg-primary">
                                                        Selesai
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        {{ ucfirst($r->status_reservasi) }}
                                                    </span>
                                                @endif
                                            </td>

                                            {{-- STATUS PEMBAYARAN --}}
                                            <td>
                                                @if(!$pembayaran)
                                                    <span class="badge bg-secondary">
                                                        Belum Bayar
                                                    </span>

                                                @elseif($pembayaran->status_pembayaran === 'menunggu')
                                                    <span class="badge bg-warning text-dark">
                                                        Menunggu Verifikasi
                                                    </span>

                                                @elseif($pembayaran->status_pembayaran === 'diterima')
                                                    <span class="badge bg-success">
                                                        Lunas
                                                    </span>

                                                @elseif($pembayaran->status_pembayaran === 'ditolak')
                                                    <span class="badge bg-danger">
                                                        Ditolak
                                                    </span>

                                                @else
                                                    <span class="badge bg-secondary">
                                                        {{ ucfirst($pembayaran->status_pembayaran) }}
                                                    </span>
                                                @endif
                                            </td>

                                            {{-- AKSI --}}
                                            <td>
                                                <a href="{{ route('reservasi.show', $r->id_reservasi) }}"
                                                   class="btn btn-sm btn-info mb-1">
                                                    Detail
                                                </a>

                                                @if(!$pembayaran && $r->status_reservasi === 'menunggu')
                                                    <a href="{{ route('pembayaran.create', $r->id_reservasi) }}"
                                                       class="btn btn-sm btn-primary mb-1">
                                                        Bayar
                                                    </a>
                                                @elseif($pembayaran && $pembayaran->status_pembayaran === 'ditolak')
                                                    <a href="{{ route('pembayaran.create', $r->id_reservasi) }}"
                                                       class="btn btn-sm btn-warning mb-1">
                                                        Bayar Ulang
                                                    </a>
                                                @endif
                                            </td>

                                        </tr>

                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    @else

                        <div class="text-center py-4">
                            <i class="bi bi-calendar-x display-4 text-muted"></i>

                            <p class="mt-2">
                                Anda belum memiliki reservasi.
                            </p>

                            <a href="{{ route('kamars.index') }}"
                               class="btn btn-primary">
                                Pesan Kamar Sekarang
                            </a>
                        </div>

                    @endif

                </div>
            </div>
        </div>
    </div>

</div>
@endsection
