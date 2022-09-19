<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VillageTemp extends Model
{
    protected $table    = "desa_temp";
    protected $fillable = [
        'kecamatan_id',
        'nama_desa'
    ];
    
    public function district()
    {
        return $this->belongsTo(District::class, 'kecamatan_id');
    }
}
