<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = 'reservasis';

    protected $primaryKey = 'id_reservasi';

    protected $fillable = [
        'id_user',
        'id_kamar',
        'id_admin',
        'tgl_checkin',
        'tgl_checkout',
        'total_bayar',
        'fasilitas_tambahan',
        'status_reservasi',
    ];

    protected function casts(): array
    {
        return [
            'tgl_checkin'  => 'date',
            'tgl_checkout' => 'date',
            'total_bayar'  => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'id_kamar', 'id_kamar');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function pembayarans()
    {
        return $this->hasMany(
            Pembayaran::class,
            'id_reservasi',
            'id_reservasi'
        );
    }
    public function getRouteKeyName(): string
    {
        return 'id_reservasi';
    }
}
