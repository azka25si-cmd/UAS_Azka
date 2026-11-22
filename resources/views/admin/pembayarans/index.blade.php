
@extends('layouts.admin.app')

@section('title', 'Verifikasi Pembayaran')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h2 class="fw-bold mb-1" style="color: #245c45;">Verifikasi Pembayaran</h2>
            <p class="text-muted mb-0">Periksa bukti dan status pembayaran pelanggan.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}"
           class="btn text-white"
           style="background-color: #47795d;">
            <i class="bi bi-arrow-left"></i> Dashboard
        </a>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 14px; background: #fffdf7;">
        <div class="card-body p-3 p-md-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr style="background-color: #e8efe7; color: #245c45;">
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Kamar</th>
                            <th>Tanggal Bayar</th>
                            <th>Jumlah</th>
                            <th>Bukti Transfer</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembayarans as $index => $p)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $p->reservasi->user->nama_lengkap ?? '-' }}</td>
                                <td>{{ $p->reservasi->kamar->no_kamar ?? '-' }}</td>
                                <td>{{ $p->tgl_bayar ?? '-' }}</td>
                                <td class="fw-semibold">
                                    Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if($p->bukti_transfer)
                                        <a href="{{ asset('storage/'.$p->bukti_transfer) }}"
                                           target="_blank"
                                           class="btn btn-sm"
                                           style="color: #245c45; border: 1px solid #47795d;">
                                            <i class="bi bi-image"></i> Lihat Bukti
                                        </a>
                                    @else
                                        <span class="text-muted">Belum ada bukti</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $paymentColor = [
                                            'menunggu' => '#fff0c2',
                                            'diterima' => '#dcefe2',
                                            'ditolak' => '#f8dddd',
                                        ][$p->status_pembayaran] ?? '#eeeeee';

                                        $paymentText = [
                                            'menunggu' => '#856404',
                                            'diterima' => '#245c45',
                                            'ditolak' => '#842029',
                                        ][$p->status_pembayaran] ?? '#555555';
                                    @endphp

                                    <span class="badge px-3 py-2"
                                          style="background: {{ $paymentColor }}; color: {{ $paymentText }};">
                                        {{ ucfirst($p->status_pembayaran) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-2">
                                        <form action="{{ route('admin.pembayarans.verifikasi', $p->id_pembayaran) }}"
                                              method="POST">
                                            @csrf
                                            @method('PUT')

                                            <select name="status_pembayaran"
                                                    class="form-select form-select-sm"
                                                    onchange="this.form.submit()">
                                                <option value="menunggu" {{ $p->status_pembayaran === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                <option value="diterima" {{ $p->status_pembayaran === 'diterima' ? 'selected' : '' }}>Diterima</option>
                                                <option value="ditolak" {{ $p->status_pembayaran === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                            </select>

                                            <input type="hidden" name="tgl_bayar" value="{{ $p->tgl_bayar ?? today()->toDateString() }}">
                                        </form>

                                        @if($p->reservasi)
                                            <a href="{{ route('admin.reservasis.show', $p->reservasi->id_reservasi) }}"
                                               class="btn btn-sm text-white"
                                               style="background-color: #47795d;">
                                                <i class="bi bi-eye"></i> Detail Reservasi
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Belum ada data pembayaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
