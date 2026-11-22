@extends('layouts.admin.app')
@section('title','Dashboard Admin')
@section('page-heading','Dashboard')
@section('content')
<div class="page-heading"><div><h1>Dashboard</h1><p>Ringkasan pengelolaan kamar dan reservasi Wisma Kita.</p></div><span class="badge rounded-pill badge-soft px-3 py-2"><i class="bi bi-calendar3 me-1"></i>{{ now()->translatedFormat('d F Y') }}</span></div>
<div class="row g-3 mb-4">
<div class="col-12 col-sm-6 col-xl-3"><div class="stat-card"><div class="stat-icon"><i class="bi bi-door-closed"></i></div><div class="stat-label">Total Kamar</div><div class="stat-value">{{ $kamars->count() }}</div></div></div>
<div class="col-12 col-sm-6 col-xl-3"><div class="stat-card"><div class="stat-icon"><i class="bi bi-check2-circle"></i></div><div class="stat-label">Kamar Tersedia</div><div class="stat-value">{{ $kamars->where('status_kamar','tersedia')->count() }}</div></div></div>
<div class="col-12 col-sm-6 col-xl-3"><div class="stat-card"><div class="stat-icon"><i class="bi bi-calendar-check"></i></div><div class="stat-label">Total Reservasi</div><div class="stat-value">{{ $reservasis->count() }}</div></div></div>
<div class="col-12 col-sm-6 col-xl-3"><div class="stat-card"><div class="stat-icon"><i class="bi bi-people"></i></div><div class="stat-label">Pelanggan Terdaftar</div><div class="stat-value">{{ $users->count() }}</div></div></div>
</div>
<div class="content-card"><div class="card-heading"><h2><i class="bi bi-clock-history me-2"></i>Reservasi Terbaru</h2><a href="{{ route('admin.reservasis.index') }}" class="btn btn-outline-green btn-sm">Lihat semua</a></div>
<div class="table-responsive"><table class="table"><thead><tr><th>No.</th><th>Pelanggan</th><th>Kamar</th><th>Check-in</th><th>Check-out</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
@forelse($reservasis->sortByDesc('created_at')->take(5) as $r)
<tr><td>{{ $loop->iteration }}</td><td>{{ $r->user->nama_lengkap ?? '-' }}</td><td>{{ $r->kamar->no_kamar ?? '-' }}</td><td>{{ $r->tgl_checkin ? \Carbon\Carbon::parse($r->tgl_checkin)->format('d/m/Y') : '-' }}</td><td>{{ $r->tgl_checkout ? \Carbon\Carbon::parse($r->tgl_checkout)->format('d/m/Y') : '-' }}</td><td><span class="badge badge-soft">{{ ucfirst($r->status_reservasi ?? '-') }}</span></td><td><a href="{{ route('admin.reservasis.show',$r->id_reservasi) }}" class="btn btn-outline-green btn-sm">Detail</a></td></tr>
@empty<tr><td colspan="7" class="text-center text-muted py-5">Belum ada data reservasi.</td></tr>@endforelse
</tbody></table></div></div>
@endsection
