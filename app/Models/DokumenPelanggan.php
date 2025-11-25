<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenPelanggan extends Model
{
    protected $table = 'dokumen_pelanggan';
    protected $primaryKey = 'dokumen_id';
    public $timestamps = false;

    protected $fillable = [
        'pelanggan_id',
        'jenis_dokumen',
        'file_path'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }
}
