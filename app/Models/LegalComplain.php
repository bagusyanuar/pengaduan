<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalComplain extends Model
{
    use HasFactory;

    protected $fillable = [
        'complain_id',
        'assignment',
        'ad_art',
    ];

    public function complain()
    {
        return $this->belongsTo(Complain::class, 'complain_id');
    }
}
