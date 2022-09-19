<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Harvest extends Model
{
    protected $table    = "panen";
    protected $with     = ['plant'];
    protected $fillable = [
        'id_petani',
        'id_tanam',
        'id_komoditas',
        'tanggal_panen',
        'jumlah_panen'
    ];

    public function plant()
    {
        return $this->belongsTo(Plant::class, 'id_tanam');
    }

    public function farmer()
    {
        return $this->belongsTo(Farmer::class, 'id_petani');
    }
}