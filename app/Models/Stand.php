<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stand extends Model
{
    /** @use HasFactory<\Database\Factories\StandFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'active',
        'qrToken',
        'ownerUserId',
        'totalVisits',
        'totalSurveys',
        'avgRating',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'ownerUserId');
    }
}

