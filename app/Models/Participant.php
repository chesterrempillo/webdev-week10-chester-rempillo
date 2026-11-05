<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participant extends Model
{
    protected $fillable = [
        'name',
        'email',
    ];

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(
            Event::class,
            'event_participant'
        )->withPivot('status')->withTimestamps();
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventParticipant::class);
    }
}