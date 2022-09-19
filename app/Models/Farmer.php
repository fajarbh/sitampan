<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    protected $table    = "petani";
    protected $fillable = [
        'id_kelompok',
        'nama_petani',
        'id_desa',
        'status',
        'id_user',
        'photo',
        'alamat',
    ];

    public function farmer_group()
    {
        return $this->belongsTo(FarmerGroup::class, 'id_kelompok');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'id_desa');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
