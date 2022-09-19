<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plant extends Model
{
    protected $table    = "tanam";
    protected $cast = [
        'tanggal_tanam' => 'date'
    ];
    protected $with = ['commodity'];
    protected $fillable = [
        'id_komoditas',
        'id_petani',
        'tanggal_tanam',
        'jumlah_tanam',
        'luas_tanam',
        'jenis_pupuk',
        'biaya_produksi',
        'longitude',
        'latitude'
    ];

    public function farmer()
    {
        return $this->belongsTo(Farmer::class, 'id_petani');
    }

    public function commodity()
    {
        return $this->belongsTo(Commodity::class, 'id_komoditas')->select('id', 'nama_komoditas', 'icon','id_jenis');
    }
}
