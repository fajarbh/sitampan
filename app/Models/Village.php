<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $table    = "desa";
    protected $casts = [
        "geoJson" => "array"
    ];
    protected $fillable = [
        'id',
        'nama_desa',
        'id_kecamatan',
        'geoJson'
    ];
    
    public function district()
    {
        return $this->belongsTo(District::class, 'id_kecamatan');
    }
}
