
@extends('layouts.admin.app')

@section('title', 'Kelola Reservasi')
@section('page-heading', 'Data Reservasi')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold mb-1" style="color: #245c45;">
                Data Reservasi
            </h2>
            <p class="text-muted mb-0">
                Kelola dan pantau seluruh reservasi pelanggan Wisma Kita.
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="btn text-white px-3"
           style="background-color: #47795d;">
            <i class="bi bi-arrow-left me-1"></i> Dashboard
        </a>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- RINGKASAN --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm"
                 style="border-radius: 14px; background: #fffdf7;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Reservasi</p>
                            <h3 class="fw-bold mb-0" style="color: #245c45;">
                                {{ $reservasis->count() }}
                            </h3>
                        </div>
                        <div class="rounded-3 p-3"
                             style="background: #e8efe7; color: #245c45;">
                            <i class="bi bi-calendar-check fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm"
                 style="border-radius: 14px; background: #fffdf7;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Menunggu Konfirmasi</p>
                            <h3 class="fw-bold mb-0 text-warning">
                                {{ $reservasis->where('status_reservasi', 'menunggu')->count() }}
                            </h3>
                        </div>
                        <div class="rounded-3 p-3"
                             style="background: #fff0c2; color: #856404;">
                            <i class="bi bi-hourglass-split fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm"
                 style="border-radius: 14px; background: #fffdf7;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Reservasi Dikonfirmasi</p>
                            <h3 class="fw-bold mb-0 text-success">
                                {{ $reservasis->where('status_reservasi', 'dikonfirmasi')->count() }}
                            </h3>
                        </div>
                        <div class="rounded-3 p-3"
                             style="background: #dcefe2; color: #245c45;">
                            <i class="bi bi-check-circle fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL RESERVASI --}}
    <div class="card border-0 shadow-sm"
         style="border-radius: 14px; background: #fffdf7;">

        <div class="card-header border-0 bg-transparent p-4 pb-2">
            <h5 class="fw-bold mb-1" style="color: #245c45;">
                <i class="bi bi-list-ul me-2"></i>Daftar Reservasi
            </h5>
            <p class="text-muted small mb-0">
                Informasi reservasi dan status pembayaran pelanggan.
            </p>
        </div>

        <div class="card-body p-3 p-md-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr style="background-color: #e8efe7; color: #245c45;">
                            <th>No</th>
                            <th>Pelanggan</th>
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
                        @forelse($reservasis as $index => $r)
                            @php
                                $pembayaran = $r->pembayarans
                                    ->sortByDesc('created_at')
                                    ->first();

                                $statusPembayaran = $pembayaran
                                    ? $pembayaran->status_pembayaran
                                    : 'belum_bayar';

                                $statusReservasiStyle = [
                                    'menunggu' => ['#fff0c2', '#856404'],
                                    'dikonfirmasi' => ['#dcefe2', '#245c45'],
                                    'dibatalkan' => ['#f8dddd', '#842029'],
                                    'selesai' => ['#dce8f5', '#284b75'],
                                ][$r->status_reservasi] ?? ['#eeeeee', '#555555'];

                                $statusPembayaranStyle = [
                                    'belum_bayar' => ['#eeeeee', '#555555'],
                                    'menunggu' => ['#fff0c2', '#856404'],
                                    'diterima' => ['#dcefe2', '#245c45'],
                                    'ditolak' => ['#f8dddd', '#842029'],
                                ][$statusPembayaran] ?? ['#eeeeee', '#555555'];

                                $labelPembayaran = [
                                    'belum_bayar' => 'Belum Bayar',
                                    'menunggu' => 'Menunggu Verifikasi',
                                    'diterima' => 'Diterima',
                                    'ditolak' => 'Ditolak',
                                ][$statusPembayaran] ?? ucfirst($statusPembayaran);
                            @endphp

                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>
                                    <div class="fw-semibold">
                                        {{ $r->user->nama_lengkap ?? '-' }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $r->user->email ?? '-' }}
                                    </small>
                                </td>

                                <td>
                                    <span class="fw-semibold">
                                        {{ $r->kamar->no_kamar ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($r->tgl_checkin)->format('d/m/Y') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($r->tgl_checkout)->format('d/m/Y') }}
                                </td>

                                <td class="fw-semibold">
                                    Rp {{ number_format($r->total_bayar, 0, ',', '.') }}
                                </td>

                                <td>
                                    <span class="badge px-3 py-2"
                                          style="background: {{ $statusReservasiStyle[0] }};
                                                 color: {{ $statusReservasiStyle[1] }};">
                                        {{ ucfirst($r->status_reservasi) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge px-3 py-2"
                                          style="background: {{ $statusPembayaranStyle[0] }};
                                                 color: {{ $statusPembayaranStyle[1] }};">
                                        {{ $labelPembayaran }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex flex-column gap-2"
                                         style="min-width: 145px;">

                                        <a href="{{ route('admin.reservasis.show', $r->id_reservasi) }}"
                                           class="btn btn-sm text-white"
                                           style="background-color: #47795d;">
                                            <i class="bi bi-eye me-1"></i> Detail
                                        </a>

                                        <form action="{{ route('admin.reservasis.update', $r->id_reservasi) }}"
                                              method="POST">
                                            @csrf
                                            @method('PUT')

                                            <select name="status_reservasi"
                                                    class="form-select form-select-sm"
                                                    onchange="this.form.submit()">
                                                <option value="menunggu"
                                                    {{ $r->status_reservasi === 'menunggu' ? 'selected' : '' }}>
                                                    Menunggu
                                                </option>
                                                <option value="dikonfirmasi"
                                                    {{ $r->status_reservasi === 'dikonfirmasi' ? 'selected' : '' }}>
                                                    Dikonfirmasi
                                                </option>
                                                <option value="dibatalkan"
                                                    {{ $r->status_reservasi === 'dibatalkan' ? 'selected' : '' }}>
                                                    Dibatalkan
                                                </option>
                                                <option value="selesai"
                                                    {{ $r->status_reservasi === 'selesai' ? 'selected' : '' }}>
                                                    Selesai
                                                </option>
                                            </select>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">
                                    <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                                    Belum ada data reservasi.
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
