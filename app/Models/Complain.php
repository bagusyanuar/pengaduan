<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'date',
        'name',
        'address',
        'job',
        'phone',
        'email',
        'complain',
        'type',
        'status',
        'target',
        'satker_id',
        'ppk_id',
        'description',
    ];

    public function legal()
    {
        return $this->hasOne(LegalComplain::class, 'complain_id');
    }
}
