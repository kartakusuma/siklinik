<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RekamMedis extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rekam_medis';

    protected $guarded = [
        'id', 'created_at', 'updated_at',
    ];

    public function pasien()
    {
        return $this->belongsTo('App\Models\Pasien', 'pasien_id', 'id');
    }

    public function perawat()
    {
        return $this->belongsTo('App\Models\User', 'perawat_id', 'id');
    }

    public function dokter()
    {
        return $this->belongsTo('App\Models\User', 'dokter_id', 'id');
    }

    public function ruang()
    {
        return $this->belongsTo('App\Models\Ruang', 'ruang_id', 'id');
    }
}
