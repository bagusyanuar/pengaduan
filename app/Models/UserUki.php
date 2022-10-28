<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUki extends Model
{
    use HasFactory;

    protected $table = 'user_uki';

    protected $fillable = [
        'user_id',
        'name',
        'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
