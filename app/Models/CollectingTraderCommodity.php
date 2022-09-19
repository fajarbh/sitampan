<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectingTraderCommodity extends Model
{
    protected $table    = "komoditas_pengepul";
    protected $fillable = [
        'id_pengepul',
        'id_penyuluh',
        'id_komoditas',
        'harga',
    ];

    public function collecting_trader()
    {
        return $this->belongsTo(CollectingTrader::class, 'id_pengepul');
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'id_penyuluh');
    }

    public function commodity()
    {
        return $this->belongsTo(Commodity::class, 'id_komoditas');
    }
}
