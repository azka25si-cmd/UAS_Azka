<?php
namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('admin.dashboard');
    }

    public function user()
    {
        return view('user.dashboard');
    }
}
