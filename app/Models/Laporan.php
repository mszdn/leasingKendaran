<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'laporan_id';
    public $timestamps = false;

    protected $fillable = [
        'tanggal_laporan',
        'total_pendapatan',
        'total_tunggakan'
    ];
}
