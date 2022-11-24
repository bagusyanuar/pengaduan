<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplainAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'complain_id',
        'date_upload',
        'date_answer',
        'file',
        'status',
        'description',
        'author_upload',
        'author_answer',
    ];

    public function complain()
    {
        return $this->belongsTo(Complain::class, 'complain_id');
    }

    public function author_upload()
    {
        return $this->belongsTo(User::class, 'author_upload');
    }

    public function author_answer()
    {
        return $this->belongsTo(User::class, 'author_answer');
    }
}
