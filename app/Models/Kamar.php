<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Kamar extends Model
{
    protected $table = 'kamars';
    protected $primaryKey = 'id_kamar';
    

    protected $fillable = [
        'no_kamar',
        'tipe_kamar',
        'harga_per_malam',
        'status_kamar',
    ];

    public function reservasis()
    {
        return $this->hasMany(
            Reservasi::class,
            'id_kamar',
            'id_kamar'
        );
    }
}
