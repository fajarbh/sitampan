<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollectingTrader extends Model
{
    protected $table    = "pengepul";
    protected $fillable = [
        'nama_pengepul',
        'alamat',
        'kontak',
        'lokasi_distribusi',
    ];
}
