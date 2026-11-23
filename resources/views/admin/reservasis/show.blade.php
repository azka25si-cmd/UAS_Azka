
@extends('layouts.admin.app')

@section('title', 'Detail Reservasi')
@section('page-heading', 'Detail Reservasi')

@section('content')
<div class="container-fluid py-4">

    @php
        $checkin = \Carbon\Carbon::parse($reservasi->tgl_checkin);
        $checkout = \Carbon\Carbon::parse($reservasi->tgl_checkout);
        $durasi = $checkin->diffInDays($checkout);

        $statusReservasi = [
            'menunggu' => ['#fff0c2', '#856404'],
            'dikonfirmasi' => ['#dcefe2', '#245c45'],
            'dibatalkan' => ['#f8dddd', '#842029'],
            'selesai' => ['#dce8f5', '#284b75'],
        ][$reservasi->status_reservasi] ?? ['#eeeeee', '#555555'];
    @endphp

    {{-- HEADER --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1" style="color: #245c45;">
                Detail Reservasi
            </h2>
            <p class="text-muted mb-0">
                Informasi lengkap reservasi pelanggan Wisma Kita.
            </p>
        </div>

        <a href="{{ route('admin.reservasis.index') }}"
           class="btn text-white px-3"
           style="background-color: #47795d;">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- RINGKASAN RESERVASI --}}
    <div class="card border-0 shadow-sm mb-4"
         style="border-radius: 14px; background: #fffdf7;">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <p class="text-muted mb-1">Nomor Reservasi</p>
                    <h4 class="fw-bold mb-0" style="color: #245c45;">
                        #{{ $reservasi->id_reservasi }}
                    </h4>
                </div>

                <div>
                    <p class="text-muted mb-2">Status Reservasi</p>
                    <span class="badge px-3 py-2"
                          style="background: {{ $statusReservasi[0] }};
                                 color: {{ $statusReservasi[1] }};">
                        {{ ucfirst($reservasi->status_reservasi) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">

        {{-- INFORMASI PELANGGAN --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100"
                 style="border-radius: 14px; background: #fffdf7;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4" style="color: #245c45;">
                        <i class="bi bi-person-circle me-2"></i>
                        Informasi Pelanggan
                    </h5>

                    <p><strong>Nama Lengkap:</strong><br>
                        {{ $reservasi->user->nama_lengkap ?? '-' }}
                    </p>

                    <p><strong>Email:</strong><br>
                        {{ $reservasi->user->email ?? '-' }}
                    </p>

                    <p class="mb-0"><strong>Nomor HP:</strong><br>
                        {{ $reservasi->user->no_hp ?? '-' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- INFORMASI KAMAR --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100"
                 style="border-radius: 14px; background: #fffdf7;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4" style="color: #245c45;">
                        <i class="bi bi-door-open me-2"></i>
                        Informasi Kamar
                    </h5>

                    <p><strong>Nomor Kamar:</strong><br>
                        {{ $reservasi->kamar->no_kamar ?? '-' }}
                    </p>

                    <p><strong>Tipe Kamar:</strong><br>
                        {{ $reservasi->kamar->tipe_kamar ?? '-' }}
                    </p>

                    <p class="mb-0"><strong>Harga per Malam:</strong><br>
                        Rp {{ number_format($reservasi->kamar->harga_per_malam ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- JADWAL RESERVASI --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100"
                 style="border-radius: 14px; background: #fffdf7;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4" style="color: #245c45;">
                        <i class="bi bi-calendar-check me-2"></i>
                        Jadwal Reservasi
                    </h5>

                    <p><strong>Tanggal Check-in:</strong><br>
                        {{ $checkin->format('d F Y') }}
                    </p>

                    <p><strong>Tanggal Check-out:</strong><br>
                        {{ $checkout->format('d F Y') }}
                    </p>

                    <p class="mb-0"><strong>Durasi Menginap:</strong><br>
                        {{ $durasi }} Malam
                    </p>
                </div>
            </div>
        </div>

        {{-- RINCIAN BIAYA --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100"
                 style="border-radius: 14px; background: #fffdf7;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4" style="color: #245c45;">
                        <i class="bi bi-receipt me-2"></i>
                        Rincian Biaya
                    </h5>

                    <p><strong>Harga per Malam:</strong><br>
                        Rp {{ number_format($reservasi->kamar->harga_per_malam ?? 0, 0, ',', '.') }}
                    </p>

                    <p><strong>Durasi:</strong><br>
                        {{ $durasi }} Malam
                    </p>

                    <p><strong>Fasilitas Tambahan:</strong><br>
                        {{ $reservasi->fasilitas_tambahan ?: 'Tidak ada' }}
                    </p>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">
                        <strong>Total Pembayaran</strong>
                        <h5 class="fw-bold mb-0" style="color: #245c45;">
                            Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- RIWAYAT PEMBAYARAN --}}
    <div class="card border-0 shadow-sm mt-4"
         style="border-radius: 14px; background: #fffdf7;">
        <div class="card-body p-4">

            <h5 class="fw-bold mb-4" style="color: #245c45;">
                <i class="bi bi-wallet2 me-2"></i>
                Riwayat Pembayaran
            </h5>

            @forelse($reservasi->pembayarans as $pembayaran)

                @php
                    $statusBayar = [
                        'menunggu' => ['#fff0c2', '#856404', 'Menunggu Verifikasi'],
                        'diterima' => ['#dcefe2', '#245c45', 'Diterima'],
                        'ditolak' => ['#f8dddd', '#842029', 'Ditolak'],
                    ][$pembayaran->status_pembayaran] ?? ['#eeeeee', '#555555', ucfirst($pembayaran->status_pembayaran)];
                @endphp

                <div class="p-3 p-md-4 mb-3"
                     style="background: #f2f5ed; border-radius: 12px;">

                    <div class="row g-4">

                        <div class="col-md-6">
                            <p>
                                <strong>Jumlah Pembayaran:</strong><br>
                                Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                            </p>

                            <p class="mb-0">
                                <strong>Tanggal Pembayaran:</strong><br>
                                {{ $pembayaran->tgl_bayar
                                    ? \Carbon\Carbon::parse($pembayaran->tgl_bayar)->format('d F Y')
                                    : '-' }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <p>
                                <strong>Status Pembayaran:</strong><br>
                                <span class="badge px-3 py-2"
                                      style="background: {{ $statusBayar[0] }};
                                             color: {{ $statusBayar[1] }};">
                                    {{ $statusBayar[2] }}
                                </span>
                            </p>

                            @if($pembayaran->bukti_transfer)
                                <div>
                                    <strong class="d-block mb-2">Bukti Transfer:</strong>

                                    <a href="{{ asset('storage/'.$pembayaran->bukti_transfer) }}"
                                       target="_blank">
                                        <img src="{{ asset('storage/'.$pembayaran->bukti_transfer) }}"
                                             alt="Bukti Transfer"
                                             class="img-thumbnail"
                                             style="max-width: 180px; max-height: 180px; object-fit: cover;">
                                    </a>

                                    <p class="small text-muted mt-2 mb-0">
                                        Klik gambar untuk melihat ukuran penuh.
                                    </p>
                                </div>
                            @else
                                <span class="text-muted">
                                    Belum ada bukti transfer.
                                </span>
                            @endif
                        </div>

                    </div>
                </div>

            @empty
                <div class="p-4 text-center"
                     style="background: #fff4d6; border-radius: 10px; color: #856404;">
                    <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                    Belum ada pembayaran untuk reservasi ini.
                </div>
            @endforelse

        </div>
    </div>

</div>
@endsection
