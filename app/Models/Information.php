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
        'information_source',
        'purpose',
        'source',
        'type',
        'status',
        'is_finish',
        'finish_at',
        'status',
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
        return $this->hasOne(LegalInformation::class, 'information_id');
    }

    public function answers()
    {
        return $this->hasMany(InformationAnswer::class, 'information_id');
    }

    public function unit()
    {
        return $this->belongsTo(SatuanKerja::class, 'satker_id');
    }

    public function ppk()
    {
        return $this->belongsTo(PPK::class, 'ppk_id');
    }

    public function getHasAnswerAttribute()
    {
        return $this->hasOne(InformationAnswer::class, 'information_id')
            ->where('status', '=', 0)->first() !== null ? true : false;
    }

    public function last_answer()
    {
        return $this->hasOne(InformationAnswer::class, 'information_id')->orderBy('id', 'DESC');
    }

    public function answer()
    {
        return $this->hasOne(InformationAnswer::class, 'information_id')->where('status', '=', 0);
    }

    public function approved_answer()
    {
        return $this->hasOne(InformationAnswer::class, 'information_id')->where('status', '=', 9)->orderBy('date_answer', 'DESC');
    }

    public function getHasApprovedAnswerAttribute()
    {
        return $this->hasOne(InformationAnswer::class, 'information_id')
            ->where('status', '=', 9)->first() !== null ? true : false;
    }
}
