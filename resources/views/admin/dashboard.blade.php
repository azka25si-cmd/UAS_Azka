<h1>Dashboard Admin</h1>
<p>Selamat datang, {{ Auth::guard('admin')->user()->nama_admin }}</p>

<form action="{{ route('admin.logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>