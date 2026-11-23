<?php
namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    // Menampilkan form reservasi
    public function create(Kamar $kamar)
    {
        return view('reservasi.create', compact('kamar'));
    }

    // Menyimpan reservasi baru
    public function store(Request $request)
    {
        $request->validate([
            'id_kamar'           => 'required|exists:kamars,id_kamar',
            'tgl_checkin'        => 'required|date|after_or_equal:today',
            'tgl_checkout'       => 'required|date|after:tgl_checkin',
            'fasilitas_tambahan' => 'nullable|string',
        ]);

        $kamar = Kamar::findOrFail($request->id_kamar);

        // Cek apakah kamar sudah dipesan
        if ($this->hasOverlap(
            $request->id_kamar,
            $request->tgl_checkin,
            $request->tgl_checkout
        )) {
            return back()
                ->withErrors([
                    'error' => 'Kamar sudah dipesan untuk tanggal yang dipilih.',
                ])
                ->withInput();
        }

        // Menghitung total pembayaran
        $hari = Carbon::parse($request->tgl_checkin)
            ->diffInDays(Carbon::parse($request->tgl_checkout));

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

        return redirect()
            ->route('pembayaran.create', $reservasi->id_reservasi)
            ->with('success', 'Reservasi berhasil dibuat. Silakan lakukan pembayaran.');
    }

    // Menampilkan detail reservasi pelanggan
    public function show(Reservasi $reservasi)
    {
        $this->authorizeReservasi($reservasi);

        $reservasi->load(['kamar', 'pembayarans']);

        return view('reservasi.show', compact('reservasi'));
    }

    // Menampilkan form edit reservasi
    public function edit(Reservasi $reservasi)
    {
        $this->authorizeReservasi($reservasi);

        return view('reservasi.edit', compact('reservasi'));
    }

    // Memperbarui reservasi pelanggan
    public function update(Request $request, Reservasi $reservasi)
    {
        $this->authorizeReservasi($reservasi);

        $request->validate([
            'tgl_checkin'        => 'required|date|after_or_equal:today',
            'tgl_checkout'       => 'required|date|after:tgl_checkin',
            'fasilitas_tambahan' => 'nullable|string',
        ]);

        // Cek bentrok tanggal, kecuali reservasi sendiri
        if ($this->hasOverlap(
            $reservasi->id_kamar,
            $request->tgl_checkin,
            $request->tgl_checkout,
            $reservasi->id_reservasi
        )) {
            return back()
                ->withErrors([
                    'error' => 'Kamar sudah dipesan untuk tanggal yang dipilih.',
                ])
                ->withInput();
        }

        $kamar = Kamar::findOrFail($reservasi->id_kamar);

        $hari = Carbon::parse($request->tgl_checkin)
            ->diffInDays(Carbon::parse($request->tgl_checkout));

        $total = $hari * $kamar->harga_per_malam;

        $reservasi->update([
            'tgl_checkin'        => $request->tgl_checkin,
            'tgl_checkout'       => $request->tgl_checkout,
            'total_bayar'        => $total,
            'fasilitas_tambahan' => $request->fasilitas_tambahan,
        ]);

        return redirect()
            ->route('reservasi.show', $reservasi->id_reservasi)
            ->with('success', 'Reservasi berhasil diperbarui.');
    }

    // Membatalkan reservasi pelanggan
    public function destroy(Reservasi $reservasi)
    {
        $this->authorizeReservasi($reservasi);

        $reservasi->update([
            'status_reservasi' => 'dibatalkan',
        ]);

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Reservasi berhasil dibatalkan.');
    }

    // Menampilkan seluruh reservasi untuk admin
    public function adminIndex()
    {
        $reservasis = Reservasi::with([
            'user',
            'kamar',
            'pembayarans',
        ])
            ->latest()
            ->get();
        return view('admin.reservasis.index', compact('reservasis'));
    }

    // Memperbarui status reservasi oleh admin
    public function adminUpdate(Request $request, Reservasi $reservasi)
    {
        $request->validate([
            'status_reservasi' => 'required|in:menunggu,dikonfirmasi,dibatalkan,selesai',
        ]);

        $reservasi->update([
            'status_reservasi' => $request->status_reservasi,
        ]);

        return redirect()
            ->route('admin.reservasis.index')
            ->with('success', 'Status reservasi berhasil diperbarui.');
    }

    // Menampilkan detail reservasi untuk admin
    public function adminShow(Reservasi $reservasi)
    {
        abort_if(! auth('admin')->check(), 403, 'Akses hanya untuk admin.');

        $reservasi->load([
            'user',
            'kamar',
            'pembayarans',
        ]);

        return view('admin.reservasis.show', compact('reservasi'));
    }
    // Memeriksa kepemilikan reservasi
    private function authorizeReservasi(Reservasi $reservasi)
    {
        if (auth('admin')->check()) {
            return;
        }

        if (auth('web')->check()) {
            abort_if(
                (int) $reservasi->id_user !== (int) auth('web')->id(),
                403,
                'Anda tidak memiliki akses ke reservasi ini.'
            );

            return;
        }

        abort(403, 'Anda tidak memiliki akses.');
    }

    // Memeriksa apakah tanggal reservasi bertabrakan
    private function hasOverlap(
        $idKamar,
        $tglCheckin,
        $tglCheckout,
        $excludeId = null
    ) {
        return Reservasi::where('id_kamar', $idKamar)
            ->where('status_reservasi', '!=', 'dibatalkan')
            ->when($excludeId, function ($query) use ($excludeId) {
                $query->where('id_reservasi', '!=', $excludeId);
            })
            ->where('tgl_checkin', '<', $tglCheckout)
            ->where('tgl_checkout', '>', $tglCheckin)
            ->exists();
    }
}
