<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        // Jika admin masih login
        if (auth('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        // Jika pelanggan masih login
        if (auth('web')->check()) {
            return redirect()->route('user.dashboard');
        }

        // Jika belum login, tampilkan halaman login
        return view('auth.login');
    }

    // Memproses login admin atau pelanggan
    public function login(Request $request)
    {
        $request->validate([
            'account_type' => 'required|in:admin,user',
            'identity'     => 'required|string',
            'password'     => 'required|string',
        ]);

        $accountType = $request->account_type;

        // Logout kedua guard agar tidak ada sesi akun sebelumnya
        Auth::guard('admin')->logout();
        Auth::guard('web')->logout();

        // Menentukan guard dan kredensial
        if ($accountType === 'admin') {
            $guard = 'admin';

            $credentials = [
                'username' => $request->identity,
                'password' => $request->password,
            ];
        } else {
            $guard = 'web';

            $identityField = filter_var(
                $request->identity,
                FILTER_VALIDATE_EMAIL
            ) ? 'email' : 'username';

            $credentials = [
                $identityField => $request->identity,
                'password'     => $request->password,
            ];
        }

        // Memeriksa akun dan password
        if (Auth::guard($guard)->attempt($credentials)) {

            $request->session()->regenerate();

            if ($accountType === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('user.dashboard');
        }

        return back()
            ->withErrors([
                'identity' => 'Username, email, atau password tidak sesuai.',
            ])
            ->onlyInput('identity', 'account_type');
    }

    // Logout admin
    public function logoutAdmin(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Logout pelanggan
    public function logoutUser(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
