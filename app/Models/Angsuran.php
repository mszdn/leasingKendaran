<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    protected $table = 'angsuran';
    protected $primaryKey = 'angsuran_id';
    public $timestamps = false;

    protected $fillable = [
        'kontrak_id',
        'angsuran_ke',
        'jumlah_bayar',
        'tanggal_jatuh_tempo',
        'tanggal_bayar',
        'status_angsuran',
        'metode_pembayaran',
        'denda',
        'bukti_pembayaran'
    ];

    public function kontrak()
    {
        return $this->belongsTo(KontrakLeasing::class, 'kontrak_id');
    }
}
