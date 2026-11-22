
@extends('layouts.admin.app')

@section('title', 'Detail Reservasi')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h2 class="fw-bold mb-1" style="color: #245c45;">Detail Reservasi</h2>
            <p class="text-muted mb-0">Informasi lengkap reservasi pelanggan.</p>
        </div>

        <a href="{{ route('admin.reservasis.index') }}"
           class="btn text-white"
           style="background-color: #47795d;">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4"
         style="border-radius: 14px; background: #fffdf7;">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <h5 class="fw-bold mb-0" style="color: #245c45;">
                    Reservasi #{{ $reservasi->id_reservasi }}
                </h5>

                <span class="badge px-3 py-2"
                      style="background: #e8efe7; color: #245c45;">
                    {{ ucfirst($reservasi->status_reservasi) }}
                </span>
            </div>

            <hr>

            <div class="row g-4">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3" style="color: #47795d;">
                        <i class="bi bi-person"></i> Informasi Pelanggan
                    </h6>
                    <p><strong>Nama:</strong> {{ $reservasi->user->nama_lengkap ?? '-' }}</p>
                    <p><strong>Email:</strong> {{ $reservasi->user->email ?? '-' }}</p>
                    <p><strong>No. HP:</strong> {{ $reservasi->user->no_hp ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="fw-bold mb-3" style="color: #47795d;">
                        <i class="bi bi-door-open"></i> Informasi Kamar
                    </h6>
                    <p><strong>Nomor Kamar:</strong> {{ $reservasi->kamar->no_kamar ?? '-' }}</p>
                    <p><strong>Tipe Kamar:</strong> {{ $reservasi->kamar->tipe_kamar ?? '-' }}</p>
                    <p>
                        <strong>Harga per Malam:</strong>
                        Rp {{ number_format($reservasi->kamar->harga_per_malam ?? 0, 0, ',', '.') }}
                    </p>
                </div>

                <div class="col-md-6">
                    <h6 class="fw-bold mb-3" style="color: #47795d;">
                        <i class="bi bi-calendar-check"></i> Jadwal Reservasi
                    </h6>
                    <p><strong>Check-in:</strong> {{ $reservasi->tgl_checkin }}</p>
                    <p><strong>Check-out:</strong> {{ $reservasi->tgl_checkout }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="fw-bold mb-3" style="color: #47795d;">
                        <i class="bi bi-receipt"></i> Rincian Biaya
                    </h6>
                    <p>
                        <strong>Total Bayar:</strong>
                        <span class="fw-bold" style="color: #245c45;">
                            Rp {{ number_format($reservasi->total_bayar, 0, ',', '.') }}
                        </span>
                    </p>

                    <p>
                        <strong>Fasilitas Tambahan:</strong>
                        {{ $reservasi->fasilitas_tambahan ?: 'Tidak ada' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm"
         style="border-radius: 14px; background: #fffdf7;">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3" style="color: #245c45;">
                <i class="bi bi-wallet2"></i> Riwayat Pembayaran
            </h5>

            @forelse($reservasi->pembayarans as $pembayaran)
                <div class="p-3 mb-3"
                     style="background: #f2f5ed; border-radius: 10px;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p>
                                <strong>Jumlah:</strong>
                                Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}
                            </p>
                            <p>
                                <strong>Tanggal Bayar:</strong>
                                {{ $pembayaran->tgl_bayar ?? '-' }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <p>
                                <strong>Status:</strong>
                                {{ ucfirst($pembayaran->status_pembayaran) }}
                            </p>

                            @if($pembayaran->bukti_transfer)
                                <a href="{{ asset('storage/'.$pembayaran->bukti_transfer) }}"
                                   target="_blank"
                                   class="btn btn-sm text-white"
                                   style="background-color: #47795d;">
                                    <i class="bi bi-image"></i> Lihat Bukti Transfer
                                </a>
                            @else
                                <span class="text-muted">Belum ada bukti transfer.</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-3"
                     style="background: #fff4d6; border-radius: 10px; color: #856404;">
                    <i class="bi bi-info-circle"></i>
                    Belum ada pembayaran untuk reservasi ini.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
