<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bangsal extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id', 'created_at', 'updated_at',
    ];

    public function perawats()
    {
        return $this->hasMany('App\Models\User', 'bangsal_id', 'id');
    }

    public function ruangs()
    {
        return $this->hasMany('App\Models\Ruang', 'bangsal_id', 'id');
    }
}
