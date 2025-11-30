<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'pelanggan_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nik',
        'no_hp',
        'email',
        'pekerjaan',
        'alamat'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kontrak()
    {
        return $this->hasMany(KontrakLeasing::class, 'pelanggan_id', 'pelanggan_id');
    }
}