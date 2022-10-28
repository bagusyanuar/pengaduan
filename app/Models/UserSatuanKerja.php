<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSatuanKerja extends Model
{
    use HasFactory;

    protected $table = 'user_satker';

    protected $fillable = [
        'user_id',
        'satker_id',
        'name',
        'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function unit()
    {
        return $this->belongsTo(SatuanKerja::class, 'satker_id');
    }
}
