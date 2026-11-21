
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Wisma Kita</title>
</head>
<body>
    <h1>Login Wisma Kita</h1>

    @if ($errors->any())
        <p style="color: red;">
            {{ $errors->first() }}
        </p>
    @endif

    <form action="{{ route('login.process') }}" method="POST">
        @csrf

        <div>
            <label>Login sebagai</label>
            <select name="account_type" required>
                <option value="user">Pelanggan</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <div>
            <label>Username atau Email</label>
            <input
                type="text"
                name="identity"
                value="{{ old('identity') }}"
                required
            >
        </div>

        <div>
            <label>Password</label>
            <input
                type="password"
                name="password"
                required
            >
        </div>

        <button type="submit">Login</button>
    </form>
</body>
</html>
