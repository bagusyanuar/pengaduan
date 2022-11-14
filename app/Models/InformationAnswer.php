<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'information_id',
        'date_upload',
        'date_answer',
        'file',
        'status',
        'description',
        'author_upload',
        'author_answer',
    ];

    public function information()
    {
        return $this->belongsTo(Information::class, 'information_id');
    }
}