<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPPK extends Model
{
    use HasFactory;

    protected $table = 'user_ppk';

    protected $fillable = [
        'user_id',
        'ppk_id',
        'name',
        'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ppk()
    {
        return $this->belongsTo(PPK::class, 'ppk_id');
    }
}
