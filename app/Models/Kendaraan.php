<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $table = 'kendaraan';
    protected $primaryKey = 'kendaraan_id';
    public $timestamps = false;

    protected $fillable = [
        'merk',
        'tipe',
        'tahun',
        'harga',
        'status'
    ];

    public function kontrak()
    {
        return $this->hasMany(KontrakLeasing::class, 'kendaraan_id');
    }
}
