<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function create(Reservasi $reservasi)
    {
        $this->authorizePembayaran($reservasi);
        return view('pembayaran.create', compact('reservasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_reservasi' => 'required|exists:reservasis,id_reservasi',
            'tgl_bayar' => 'required|date',
            'jumlah_bayar' => 'required|numeric',
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $reservasi = Reservasi::findOrFail($request->id_reservasi);

        if ($reservasi->id_user !== auth('web')->id()) {
            abort(403);
        }

        $path = $request->file('bukti_transfer')->store('bukti_pembayaran', 'public');

        Pembayaran::create([
            'id_reservasi'   => $request->id_reservasi,
            'id_admin'       => null,
            'tgl_bayar'      => $request->tgl_bayar,
            'jumlah_bayar'   => $request->jumlah_bayar,
            'bukti_transfer' => $path,
            'status_pembayaran' => 'menunggu',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Tunggu verifikasi admin.');
    }

    public function adminIndex()
    {
        $pembayarans = Pembayaran::with(['reservasi.user', 'reservasi.kamar'])->get();
        return view('admin.pembayarans.index', compact('pembayarans'));
    }

    public function verifikasi(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:diterima,ditolak',
        ]);

        $pembayaran->update([
            'status_pembayaran' => $request->status_pembayaran,
            'id_admin' => auth('admin')->id(),
            'tgl_bayar' => $request->tgl_bayar ?? $pembayaran->tgl_bayar,
        ]);

        if ($request->status_pembayaran === 'diterima') {
            $pembayaran->reservasi->update(['status_reservasi' => 'dikonfirmasi']);
        }

        return redirect()->route('admin.pembayarans.index')
            ->with('success', 'Pembayaran diverifikasi.');
    }

    private function authorizePembayaran(Reservasi $reservasi)
    {
        if ($reservasi->id_user !== auth('web')->id()) {
            abort(403);
        }
    }
}