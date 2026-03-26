<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSurvey extends Model
{
    /** @use HasFactory<\Database\Factories\EventSurveyFactory> */
    use HasFactory;

    protected $fillable = [
        'participantId',
        'q1',
        'q2',
        'q3',
        'q4',
        'q5',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participantId');
    }
}
