<?php
namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function create(Kamar $kamar)
    {
        return view('reservasi.create', compact('kamar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kamar'           => 'required|exists:kamars,id_kamar',
            'tgl_checkin'        => 'required|date|after_or_equal:today',
            'tgl_checkout'       => 'required|date|after:tgl_checkin',
            'fasilitas_tambahan' => 'nullable|string',
        ]);

        $kamar = Kamar::findOrFail($request->id_kamar);

        // Cek double booking (overlap tanggal)
        $overlap = Reservasi::where('id_kamar', $request->id_kamar)
            ->where('status_reservasi', '!=', 'dibatalkan')
            ->where(function ($q) use ($request) {
                $q->whereBetween('tgl_checkin', [$request->tgl_checkin, $request->tgl_checkout])
                    ->orWhereBetween('tgl_checkout', [$request->tgl_checkin, $request->tgl_checkout])
                    ->orWhere(function ($q2) use ($request) {
                        $q2->where('tgl_checkin', '<=', $request->tgl_checkin)
                            ->where('tgl_checkout', '>=', $request->tgl_checkout);
                    });
            })
            ->exists();

        if ($overlap) {
            return back()->withErrors(['error' => 'Kamar sudah dipesan untuk tanggal yang dipilih.'])->withInput();
        }

        $hari  = Carbon::parse($request->tgl_checkin)->diffInDays(Carbon::parse($request->tgl_checkout));
        $total = $hari * $kamar->harga_per_malam;

        $reservasi = Reservasi::create([
            'id_user'            => auth('web')->id(),
            'id_kamar'           => $request->id_kamar,
            'tgl_checkin'        => $request->tgl_checkin,
            'tgl_checkout'       => $request->tgl_checkout,
            'total_bayar'        => $total,
            'fasilitas_tambahan' => $request->fasilitas_tambahan,
            'status_reservasi'   => 'menunggu',
        ]);

        return redirect()->route('pembayaran.create', $reservasi->id_reservasi)
            ->with('success', 'Reservasi berhasil dibuat. Silakan lakukan pembayaran.');
    }

    public function show(Reservasi $reservasi)
    {
        $this->authorizeReservasi($reservasi);
        return view('reservasi.show', compact('reservasi'));
    }

    public function edit(Reservasi $reservasi)
    {
        $this->authorizeReservasi($reservasi);
        return view('reservasi.edit', compact('reservasi'));
    }

    public function update(Request $request, Reservasi $reservasi)
    {
        $this->authorizeReservasi($reservasi);

        $request->validate([
            'tgl_checkin'        => 'required|date|after_or_equal:today',
            'tgl_checkout'       => 'required|date|after:tgl_checkin',
            'fasilitas_tambahan' => 'nullable|string',
        ]);

        // Cek double booking saat update (kecuali reservasi sendiri)
        $overlap = Reservasi::where('id_kamar', $reservasi->id_kamar)
            ->where('id_reservasi', '!=', $reservasi->id_reservasi)
            ->where('status_reservasi', '!=', 'dibatalkan')
            ->where(function ($q) use ($request) {
                $q->whereBetween('tgl_checkin', [$request->tgl_checkin, $request->tgl_checkout])
                    ->orWhereBetween('tgl_checkout', [$request->tgl_checkin, $request->tgl_checkout])
                    ->orWhere(function ($q2) use ($request) {
                        $q2->where('tgl_checkin', '<=', $request->tgl_checkin)
                            ->where('tgl_checkout', '>=', $request->tgl_checkout);
                    });
            })
            ->exists();

        if ($overlap) {
            return back()->withErrors(['error' => 'Kamar sudah dipesan untuk tanggal yang dipilih.'])->withInput();
        }

        $hari  = Carbon::parse($request->tgl_checkin)->diffInDays(Carbon::parse($request->tgl_checkout));
        $kamar = Kamar::find($reservasi->id_kamar);
        $total = $hari * $kamar->harga_per_malam;

        $reservasi->update([
            'tgl_checkin'        => $request->tgl_checkin,
            'tgl_checkout'       => $request->tgl_checkout,
            'total_bayar'        => $total,
            'fasilitas_tambahan' => $request->fasilitas_tambahan,
        ]);

        return redirect()->route('reservasi.show', $reservasi->id_reservasi)
            ->with('success', 'Reservasi diperbarui.');
    }

    public function destroy(Reservasi $reservasi)
    {
        $this->authorizeReservasi($reservasi);
        $reservasi->update(['status_reservasi' => 'dibatalkan']);
        return redirect()->route('user.dashboard')->with('success', 'Reservasi dibatalkan.');
    }

    public function adminIndex()
    {
        $reservasis = Reservasi::with(['user', 'kamar'])->get();
        return view('admin.reservasis.index', compact('reservasis'));
    }

    public function adminUpdate(Request $request, Reservasi $reservasi)
    {
        $request->validate([
            'status_reservasi' => 'required|in:menunggu,dikonfirmasi,dibatalkan,selesai',
        ]);

        $reservasi->update(['status_reservasi' => $request->status_reservasi]);
        return redirect()->route('admin.reservasis.index')
            ->with('success', 'Status reservasi diperbarui.');
    }

    private function authorizeReservasi(Reservasi $reservasi)
    {
        if (auth('web')->check() && $reservasi->id_user !== auth('web')->id()) {
            abort(403);
        }
        if (auth('admin')->check()) {
            return;
        }
        abort(403);
    }
    public function adminShow(Reservasi $reservasi)
    {
        abort_if(! auth('admin')->check(), 403, 'Akses hanya untuk admin.');

        $reservasi->load(['user', 'kamar', 'pembayarans']);

        return view('admin.reservasis.show', compact('reservasi'));
    }
}
