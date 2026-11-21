<h1>Dashboard Pelanggan</h1>
<p>Selamat datang, {{ Auth::guard('web')->user()->nama_lengkap }}</p>

<form action="{{ route('user.logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>