<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\User;

class DashboardController extends Controller
{
    public function admin()
    {
        $kamars = Kamar::all();
        $reservasis = Reservasi::with(['user', 'kamar'])->get();
        $pembayarans = Pembayaran::with(['reservasi.user', 'reservasi.kamar'])->get();
        $users = User::all();

        return view('admin.dashboard', compact('kamars', 'reservasis', 'pembayarans', 'users'));
    }

    public function user()
    {
        $user = auth('web')->user();
        $reservasis = $user->reservasis()->with(['kamar', 'pembayaran'])->get();

        return view('user.dashboard', compact('reservasis'));
    }
}