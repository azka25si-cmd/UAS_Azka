
@extends('layouts.admin.app')

@section('title', 'Verifikasi Pembayaran')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h2 class="fw-bold mb-1" style="color: #245c45;">
                Verifikasi Pembayaran
            </h2>
            <p class="text-muted mb-0">
                Periksa bukti dan status pembayaran pelanggan.
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="btn text-white"
           style="background-color: #47795d;">
            <i class="bi bi-arrow-left"></i> Dashboard
        </a>
    </div>

    {{-- PESAN NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- TABEL PEMBAYARAN --}}
    <div class="card border-0 shadow-sm"
         style="border-radius: 14px; background: #fffdf7;">

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
                                {{-- NOMOR --}}
                                <td>{{ $index + 1 }}</td>

                                {{-- PELANGGAN --}}
                                <td>
                                    {{ $p->reservasi->user->nama_lengkap ?? '-' }}
                                </td>

                                {{-- KAMAR --}}
                                <td>
                                    {{ $p->reservasi->kamar->no_kamar ?? '-' }}
                                </td>

                                {{-- TANGGAL BAYAR --}}
                                <td>
                                    {{ $p->tgl_bayar ? $p->tgl_bayar->format('d-m-Y') : '-' }}
                                </td>

                                {{-- JUMLAH --}}
                                <td class="fw-semibold">
                                    Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                                </td>

                                {{-- BUKTI TRANSFER --}}
                                <td>
                                    @if($p->bukti_transfer)
                                        <a href="{{ asset('storage/'.$p->bukti_transfer) }}"
                                           target="_blank"
                                           title="Lihat bukti pembayaran">

                                            <img src="{{ asset('storage/'.$p->bukti_transfer) }}"
                                                 alt="Bukti Transfer"
                                                 width="90"
                                                 height="70"
                                                 class="rounded border"
                                                 style="object-fit: cover;">
                                        </a>
                                    @else
                                        <span class="text-muted">
                                            Belum ada bukti
                                        </span>
                                    @endif
                                </td>

                                {{-- STATUS --}}
                                <td>
                                    @if($p->status_pembayaran === 'menunggu')
                                        <span class="badge px-3 py-2"
                                              style="background: #fff0c2; color: #856404;">
                                            Menunggu
                                        </span>

                                    @elseif($p->status_pembayaran === 'diterima')
                                        <span class="badge px-3 py-2"
                                              style="background: #dcefe2; color: #245c45;">
                                            Diterima
                                        </span>

                                    @elseif($p->status_pembayaran === 'ditolak')
                                        <span class="badge px-3 py-2"
                                              style="background: #f8dddd; color: #842029;">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
                                <td>
                                    <div class="d-flex flex-column gap-2"
                                         style="min-width: 145px;">

                                        @if($p->status_pembayaran === 'menunggu')

                                            {{-- TERIMA --}}
                                            <form action="{{ route('admin.pembayarans.verifikasi', $p->id_pembayaran) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Apakah kamu yakin ingin menerima pembayaran ini?')">
                                                @csrf
                                                @method('PUT')

                                                <input type="hidden"
                                                       name="status_pembayaran"
                                                       value="diterima">

                                                <button type="submit"
                                                        class="btn btn-sm btn-success w-100">
                                                    <i class="bi bi-check-circle"></i>
                                                    Terima
                                                </button>
                                            </form>

                                            {{-- TOLAK --}}
                                            <form action="{{ route('admin.pembayarans.verifikasi', $p->id_pembayaran) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Apakah kamu yakin ingin menolak pembayaran ini?')">
                                                @csrf
                                                @method('PUT')

                                                <input type="hidden"
                                                       name="status_pembayaran"
                                                       value="ditolak">

                                                <button type="submit"
                                                        class="btn btn-sm btn-danger w-100">
                                                    <i class="bi bi-x-circle"></i>
                                                    Tolak
                                                </button>
                                            </form>

                                        @else

                                            <span class="text-muted small text-center">
                                                Sudah diverifikasi
                                            </span>

                                        @endif

                                        {{-- DETAIL RESERVASI --}}
                                        @if($p->reservasi)
                                            <a href="{{ route('admin.reservasis.show', $p->reservasi->id_reservasi) }}"
                                               class="btn btn-sm text-white"
                                               style="background-color: #47795d;">
                                                <i class="bi bi-eye"></i>
                                                Detail Reservasi
                                            </a>
                                        @endif

                                    </div>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="8"
                                    class="text-center text-muted py-4">
                                    <i class="bi bi-wallet2 display-5"></i>
                                    <p class="mt-2 mb-0">
                                        Belum ada data pembayaran.
                                    </p>
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
