<header class="topbar">
<div class="d-flex align-items-center gap-3">
<button class="btn btn-light d-lg-none" id="sidebarToggle" type="button"><i class="bi bi-list fs-5"></i></button>
<div class="topbar-title">@yield('page-heading','Panel Administrasi')</div></div>
<div class="admin-chip"><div class="text-end d-none d-sm-block"><div class="fw-semibold">{{ auth('admin')->user()->nama_admin ?? 'Administrator' }}</div><small class="text-muted">Admin Wisma</small></div><div class="avatar"><i class="bi bi-person-fill"></i></div></div>
</header>
