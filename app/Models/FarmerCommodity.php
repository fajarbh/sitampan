<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerCommodity extends Model
{
    protected $table    = "komoditas_petani";
    protected $fillable = [
        'id_komoditas',
        'id_petani'
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
