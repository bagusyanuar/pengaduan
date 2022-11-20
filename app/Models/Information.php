<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

	protected $table = 'information';
    protected $fillable = [
        'ticket_id',
        'date',
		'card_id',
        'name',
        'address',
        'job',
        'phone',
        'email',
        'information',
        'purpose',
        'source',
        'type',
        'status',
        'description',
    ];

    public function legal()
    {
        return $this->hasOne(LegalInformation::class, 'information_id');
    }

    public function answers()
    {
        return $this->hasMany(InformationAnswer::class, 'information_id');
    }
}
