@extends('layouts.app')

@section('title', 'Detail Reservasi')

@section('content')
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Detail Reservasi</h2>
            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Reservasi #{{ $reservasi->id_reservasi }}</h5>

                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <p><strong>Kamar:</strong> {{ $reservasi->kamar->no_kamar }}</p>
                        <p><strong>Tipe:</strong> {{ $reservasi->kamar->tipe_kamar }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Check-in:</strong> {{ $reservasi->tgl_checkin }}</p>
                        <p><strong>Check-out:</strong> {{ $reservasi->tgl_checkout }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Total Bayar:</strong> Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}</p>
                        <p><strong>Status Reservasi:</strong>
                            <span
                                class="badge bg-{{ $reservasi->status_reservasi === 'dikonfirmasi' ? 'success' : ($reservasi->status_reservasi === 'menunggu' ? 'warning' : 'danger') }}">
                                {{ ucfirst($reservasi->status_reservasi) }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        @if ($reservasi->fasilitas_tambahan)
                            <p><strong>Fasilitas Tambahan:</strong> {{ $reservasi->fasilitas_tambahan }}</p>
                        @endif
                    </div>
                </div>

                <hr>

                @php
                    $pembayaran = $reservasi->pembayarans->sortByDesc('created_at')->first();
                @endphp

                @if ($pembayaran)
                    <div class="alert alert-info">
                        <h6>Informasi Pembayaran</h6>

                        <p>
                            <strong>Jumlah:</strong>
                            Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                        </p>

                        <p>
                            <strong>Tanggal Bayar:</strong>
                            {{ $pembayaran->tgl_bayar ?? '-' }}
                        </p>

                        <p>
                            <strong>Status Pembayaran:</strong>
                            <span
                                class="badge bg-{{ $pembayaran->status_pembayaran === 'diterima'
                                    ? 'success'
                                    : ($pembayaran->status_pembayaran === 'ditolak'
                                        ? 'danger'
                                        : 'warning') }}">
                                {{ ucfirst($pembayaran->status_pembayaran) }}
                            </span>
                        </p>

                        @if ($pembayaran->bukti_transfer)
                            <a href="{{ asset('storage/' . $pembayaran->bukti_transfer) }}" target="_blank"
                                class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-file-image"></i>
                                Lihat Bukti Transfer
                            </a>
                        @endif
                    </div>
                @else
                    <div class="alert alert-warning">
                        Anda belum mengunggah bukti pembayaran.

                        <a href="{{ route('pembayaran.create', $reservasi->id_reservasi) }}"
                            class="btn btn-primary btn-sm ms-2">
                            Bayar Sekarang
                        </a>
                    </div>
                @endif


                <div class="mt-3">
                    <button onclick="window.print()" class="btn btn-outline-primary">
                        <i class="bi bi-printer"></i> Cetak Bukti Reservasi
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
