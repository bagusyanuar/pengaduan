<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPK extends Model
{
    use HasFactory;

    protected $table = 'ppk';

    protected $fillable = [
        'satker_id',
        'name'
    ];

    public function unit()
    {
        return $this->belongsTo(SatuanKerja::class, 'satker_id');
    }
}
