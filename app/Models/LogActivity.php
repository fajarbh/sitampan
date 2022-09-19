<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogActivity extends Model
{
    // Table yg digunakan
    protected $table    = 'log_activity';

    // Mass asignment
    protected $fillable = [
        'user_id',
        'subject',
        'url',
        'method',
        'ip',
        'data_old',
        'data_new'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
