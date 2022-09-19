<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketPrice extends Model
{
    protected $table    = "harga_pasar";
    protected $fillable = [
        'id_penyuluh',
        'id_komoditas',
        'periode_bulan',
        'harga_pasar_lokal',
        'harga_pasar_induk',
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'id_penyuluh');
    }

    public function commodity()
    {
        return $this->belongsTo(Commodity::class, 'id_komoditas');
    }
}
