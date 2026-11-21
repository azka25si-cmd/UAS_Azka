@extends('layouts.app')

@section('title', 'Kelola Reservasi')

@section('content')
<div class="container-fluid mt-4">
    <h2>Data Reservasi</h2>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-3">Kembali ke Dashboard</a>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Pelanggan</th>
                <th>Kamar</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Total Bayar</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservasis as $index => $r)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $r->user->nama_lengkap }}</td>
                    <td>{{ $r->kamar->no_kamar }}</td>
                    <td>{{ $r->tgl_checkin }}</td>
                    <td>{{ $r->tgl_checkout }}</td>
                    <td>Rp {{ number_format($r->total_bayar, 0, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('admin.reservasis.update', $r->id_reservasi) }}" method="POST" style="display:inline-block;">
                            @csrf @method('PUT')
                            <select name="status_reservasi" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="menunggu" {{ $r->status_reservasi === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="dikonfirmasi" {{ $r->status_reservasi === 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                                <option value="dibatalkan" {{ $r->status_reservasi === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                <option value="selesai" {{ $r->status_reservasi === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('admin.reservasis.show', $r->id_reservasi) }}" class="btn btn-sm btn-info">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection