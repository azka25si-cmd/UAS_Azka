<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';
    protected $primaryKey = 'id_pembayaran';
    

    protected $fillable = [
        'id_reservasi',
        'id_admin',
        'tgl_bayar',
        'jumlah_bayar',
        'bukti_transfer',
        'status_pembayaran',
    ];

    protected function casts(): array
    {
        return [
            'tgl_bayar' => 'date',
            'jumlah_bayar' => 'decimal:2',
        ];
    }

    public function reservasi()
    {
        return $this->belongsTo(
            Reservasi::class,
            'id_reservasi',
            'id_reservasi'
        );
    }

    public function admin()
    {
        return $this->belongsTo(
            Admin::class,
            'id_admin',
            'id_admin'
        );
    }
}
