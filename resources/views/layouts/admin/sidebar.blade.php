<aside class="sidebar" id="adminSidebar">
<a href="{{ route('admin.dashboard') }}" class="brand"><span class="brand-mark"><i class="bi bi-house-heart-fill"></i></span><span class="brand-name">Wisma Kita<span class="brand-sub">Sistem Reservasi</span></span></a>
<div class="menu-label">MENU UTAMA</div><nav class="nav flex-column">
<a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2"></i>Dashboard</a>
<a href="{{ route('admin.kamars.index') }}" class="nav-link {{ request()->routeIs('admin.kamars.*') ? 'active' : '' }}"><i class="bi bi-door-closed"></i>Data Kamar</a>
<a href="{{ route('admin.reservasis.index') }}" class="nav-link {{ request()->routeIs('admin.reservasis.*') ? 'active' : '' }}"><i class="bi bi-calendar-check"></i>Data Reservasi</a>
<a href="{{ route('admin.pembayarans.index') }}" class="nav-link {{ request()->routeIs('admin.pembayarans.*') ? 'active' : '' }}"><i class="bi bi-wallet2"></i>Data Pembayaran</a>
</nav><div class="menu-label mt-3">AKUN</div><div class="sidebar-bottom"><form action="{{ route('admin.logout') }}" method="POST">@csrf<button class="nav-link w-100 border-0 bg-transparent text-start" type="submit"><i class="bi bi-box-arrow-left"></i>Keluar</button></form></div>
</aside>
