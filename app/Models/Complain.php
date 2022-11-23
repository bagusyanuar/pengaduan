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
        'is_finish',
        'target',
        'satker_id',
        'ppk_id',
        'description',
    ];

    protected $casts = [
        'is_finish' => 'boolean'
    ];

    public function legal()
    {
        return $this->hasOne(LegalComplain::class, 'complain_id');
    }

    public function unit()
    {
        return $this->belongsTo(SatuanKerja::class, 'satker_id');
    }

    public function ppk()
    {
        return $this->belongsTo(PPK::class, 'ppk_id');
    }

    public function answers()
    {
        return $this->hasMany(ComplainAnswer::class, 'complain_id');
    }

    public function getHasAnswerAttribute()
    {
        return $this->hasOne(ComplainAnswer::class, 'complain_id')
            ->where('status', '=', 0)->first() !== null ? true : false;
    }

    public function answer()
    {
        return $this->hasOne(ComplainAnswer::class, 'complain_id')->where('status', '=', 0);
    }

    public function getHasApprovedAnswerAttribute()
    {
        return $this->hasOne(ComplainAnswer::class, 'complain_id')
            ->where('status', '=', 9)->first() !== null ? true : false;
    }
}
