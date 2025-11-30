<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'username',
        'password',
        'role',
        'nama_lengkap',
        'email',
        'foto_profil',
        'no_hp',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'last_login',
        'is_active'
    ];

    protected $hidden = [
        'password'
    ];

     // RELASI: satu marketing bisa punya banyak kontrak
    public function kontrak()
    {
        return $this->hasMany(\App\Models\KontrakLeasing::class, 'marketing_id', 'user_id');
    }
}
