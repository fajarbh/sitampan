<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FarmerPrice extends Model
{
    protected $table    = "harga_kelompok_tani";
    protected $fillable = [
        'id_petani',
        'id_komoditas',
        'periode_bulan',
        'harga_tani',
    ];

    public function farmer()
    {
        return $this->belongsTo(Farmer::class, 'id_petani');
    }

    public function commodity()
    {
        return $this->belongsTo(Commodity::class, 'id_komoditas');
    }
}
