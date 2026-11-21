<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'admins';

    protected $primaryKey = 'id_admin';

    protected $fillable = [
        'username',
        'password',
        'nama_admin',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function reservasis()
    {
        return $this->hasMany(
            Reservasi::class,
            'id_admin',
            'id_admin'
        );
    }
    public function getRouteKeyName(): string
    {
        return 'id_admin';
    }
}
