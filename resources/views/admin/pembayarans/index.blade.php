@extends('layouts.app')

@section('title', 'Verifikasi Pembayaran')

@section('content')
<div class="container-fluid mt-4">
    <h2>Verifikasi Pembayaran</h2>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
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
            @foreach($pembayarans as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->reservasi->user->nama_lengkap }}</td>
                    <td>{{ $p->reservasi->kamar->no_kamar }}</td>
                    <td>{{ $p->tgl_bayar ?? '-' }}</td>
                    <td>Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                    <td>
                        @if($p->bukti_transfer)
                            <a href="{{ asset('storage/'.$p->bukti_transfer) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-file-image"></i> Lihat
                            </a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.pembayarans.verifikasi', $p->id_pembayaran) }}" method="POST" style="display:inline-block;">
                            @csrf @method('PUT')
                            <select name="status_pembayaran" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="menunggu" {{ $p->status_pembayaran === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="diterima" {{ $p->status_pembayaran === 'diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="ditolak" {{ $p->status_pembayaran === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            <input type="hidden" name="tgl_bayar" value="{{ $p->tgl_bayar ?? today() }}">
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('admin.reservasis.show', $p->reservasi->id_reservasi) }}" class="btn btn-sm btn-info">Detail Reservasi</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection