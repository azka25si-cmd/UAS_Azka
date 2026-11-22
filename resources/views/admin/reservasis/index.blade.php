@extends('layouts.admin.app')

@section('title', 'Kelola Reservasi')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h2 class="fw-bold mb-1" style="color: #245c45;">Data Reservasi</h2>
            <p class="text-muted mb-0">Kelola dan pantau reservasi pelanggan.</p>
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
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Total Bayar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservasis as $index => $r)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $r->user->nama_lengkap ?? '-' }}</td>
                                <td>{{ $r->kamar->no_kamar ?? '-' }}</td>
                                <td>{{ $r->tgl_checkin }}</td>
                                <td>{{ $r->tgl_checkout }}</td>
                                <td class="fw-semibold">
                                    Rp {{ number_format($r->total_bayar, 0, ',', '.') }}
                                </td>
                                <td>
                                    @php
                                        $statusColor = [
                                            'menunggu' => '#fff0c2',
                                            'dikonfirmasi' => '#dcefe2',
                                            'dibatalkan' => '#f8dddd',
                                            'selesai' => '#dce8f5',
                                        ][$r->status_reservasi] ?? '#eeeeee';

                                        $textColor = [
                                            'menunggu' => '#856404',
                                            'dikonfirmasi' => '#245c45',
                                            'dibatalkan' => '#842029',
                                            'selesai' => '#284b75',
                                        ][$r->status_reservasi] ?? '#555555';
                                    @endphp

                                    <span class="badge px-3 py-2"
                                          style="background: {{ $statusColor }}; color: {{ $textColor }};">
                                        {{ ucfirst($r->status_reservasi) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        <form action="{{ route('admin.reservasis.update', $r->id_reservasi) }}"
                                              method="POST">
                                            @csrf
                                            @method('PUT')

                                            <select name="status_reservasi"
                                                    class="form-select form-select-sm"
                                                    onchange="this.form.submit()">
                                                <option value="menunggu" {{ $r->status_reservasi === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                                <option value="dikonfirmasi" {{ $r->status_reservasi === 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                                                <option value="dibatalkan" {{ $r->status_reservasi === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                                <option value="selesai" {{ $r->status_reservasi === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                        </form>

                                        <a href="{{ route('admin.reservasis.show', $r->id_reservasi) }}"
                                           class="btn btn-sm text-white"
                                           style="background-color: #47795d;">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
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
