<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        if (auth('admin')->check()) {
            $kamars = Kamar::all();
            return view('admin.kamars.index', compact('kamars'));
        }

        $kamars = Kamar::where('status_kamar', 'tersedia')->get();
        return view('kamars.index', compact('kamars'));
    }

    public function create()
    {
        return view('admin.kamars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_kamar' => 'required|unique:kamars,no_kamar',
            'tipe_kamar' => 'required|string',
            'harga_per_malam' => 'required|numeric',
            'status_kamar' => 'required|string',
        ]);

        Kamar::create($request->all());
        return redirect()->route('admin.kamars.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function show(Kamar $kamar)
    {
        if (auth('admin')->check()) {
            return view('admin.kamars.show', compact('kamar'));
        }
        return view('kamars.show', compact('kamar'));
    }

    public function edit(Kamar $kamar)
    {
        return view('admin.kamars.edit', compact('kamar'));
    }

    public function update(Request $request, Kamar $kamar)
    {
        $request->validate([
            'no_kamar' => 'required|unique:kamars,no_kamar,'.$kamar->id_kamar,
            'tipe_kamar' => 'required|string',
            'harga_per_malam' => 'required|numeric',
            'status_kamar' => 'required|string',
        ]);

        $kamar->update($request->all());
        return redirect()->route('admin.kamars.index')->with('success', 'Kamar berhasil diperbarui.');
    }

    public function destroy(Kamar $kamar)
    {
        $kamar->delete();
        return redirect()->route('admin.kamars.index')->with('success', 'Kamar berhasil dihapus.');
    }
}