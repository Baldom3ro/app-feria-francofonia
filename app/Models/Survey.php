<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    /** @use HasFactory<\Database\Factories\SurveyFactory> */
    use HasFactory;

    protected $fillable = [
        'standId',
        'participantId',
        'rating',
    ];

    public function stand()
    {
        return $this->belongsTo(Stand::class, 'standId');
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participantId');
    }
}
