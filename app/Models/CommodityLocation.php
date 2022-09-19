<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommodityLocation extends Model
{
    protected $table    = "lokasi_komoditas";
    protected $fillable = [
        'long_komoditas',
        'lat_komoditas',
    ];
}
