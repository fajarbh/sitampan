<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commodity extends Model
{
    protected $table    = "komoditas";
    protected $fillable = [
        'nama_komoditas',
        'icon',
        'id_jenis',
    ];

    public function commodity_sector()
    {
        return $this->belongsTo(CommoditySector::class, 'id_jenis');
    }
}
