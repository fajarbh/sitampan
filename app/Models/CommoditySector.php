<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommoditySector extends Model
{
    protected $table    = "jenis_komoditas";
    protected $fillable = [
        'nama_jenis'
    ];
}
