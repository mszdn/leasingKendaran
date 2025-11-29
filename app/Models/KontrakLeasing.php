<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontrakLeasing extends Model
{
    protected $table = 'kontrak_leasing';
    protected $primaryKey = 'kontrak_id';
    public $timestamps = false;

    protected $fillable = [
        'nomor_kontrak',
        'user_id',
        'kendaraan_id',
        'tenor_bulan',
        'dp_amount',
        'angsuran_per_bulan',
        'total_pembayaran',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_kontrak',
        'status_verifikasi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'pelanggan_id');
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    public function angsuran()
    {
        return $this->hasMany(Angsuran::class, 'kontrak_id');
    }
}
