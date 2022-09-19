<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FarmerGroup extends Model
{
    protected $table    = "kelompok_tani";
    protected $with     = 'village';
    protected $fillable = [
        'nama_kelompok',
        'id_desa',
        'id_penyuluh'
    ];

    public function village()
    {
        return $this->belongsTo(Village::class, 'id_desa')->select(['id', 'nama_desa','id_kecamatan']);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'id_penyuluh');
    }
}
