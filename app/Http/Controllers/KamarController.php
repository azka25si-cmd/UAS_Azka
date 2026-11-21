<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    // === UNTUK ADMIN ===
    public function adminIndex()
    {
        abort_if(!auth('admin')->check(), 403, 'Akses hanya untuk admin.');
        
        $kamars = Kamar::all();
        return view('admin.kamars.index', compact('kamars'));
    }

    public function create()
    {
        abort_if(!auth('admin')->check(), 403, 'Akses hanya untuk admin.');
        return view('admin.kamars.create');
    }

    public function store(Request $request)
    {
        abort_if(!auth('admin')->check(), 403, 'Akses hanya untuk admin.');
        
        $request->validate([
            'no_kamar' => 'required|unique:kamars,no_kamar',
            'tipe_kamar' => 'required|string',
            'harga_per_malam' => 'required|numeric',
            'status_kamar' => 'required|string',
        ]);

        Kamar::create($request->all());
        return redirect()->route('admin.kamars.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function edit(Kamar $kamar)
    {
        abort_if(!auth('admin')->check(), 403, 'Akses hanya untuk admin.');
        return view('admin.kamars.edit', compact('kamar'));
    }

    public function update(Request $request, Kamar $kamar)
    {
        abort_if(!auth('admin')->check(), 403, 'Akses hanya untuk admin.');
        
        $request->validate([
            'no_kamar' => 'required|unique:kamars,no_kamar,'.$kamar->id_kamar.',id_kamar',
            'tipe_kamar' => 'required|string',
            'harga_per_malam' => 'required|numeric',
            'status_kamar' => 'required|string',
        ]);

        $kamar->update($request->all());
        return redirect()->route('admin.kamars.index')->with('success', 'Kamar berhasil diperbarui.');
    }

    public function destroy(Kamar $kamar)
    {
        abort_if(!auth('admin')->check(), 403, 'Akses hanya untuk admin.');
        $kamar->delete();
        return redirect()->route('admin.kamars.index')->with('success', 'Kamar berhasil dihapus.');
    }

    // === UNTUK PELANGGAN ===
    public function index()
    {
        abort_if(!auth('web')->check(), 403, 'Akses hanya untuk pelanggan.');
        
        $kamars = Kamar::where('status_kamar', 'tersedia')->get();
        return view('kamars.index', compact('kamars'));
    }

    public function show(Kamar $kamar)
    {
        abort_if(!auth('web')->check(), 403, 'Akses hanya untuk pelanggan.');
        return view('kamars.show', compact('kamar'));
    }
}