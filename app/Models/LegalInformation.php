<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalInformation extends Model
{
    use HasFactory;
	
	protected $table = 'legal_information';
	
    protected $fillable = [
        'information_id',
        'assignment',
        'ad_art',
    ];

    public function information()
    {
        return $this->belongsTo(Information::class, 'information_id');
    }
}
