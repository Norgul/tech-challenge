<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'postcode',
    ];

    protected $appends = [
        'url',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class)
            // Assuming "chronological order, newest first" means lastly created, not ordering by start/end times.
            ->latest();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class)->latest('updated_at');
    }

    public function getBookingsCountAttribute(): int
    {
        return $this->bookings->count();
    }

    public function getJournalsCountAttribute(): int
    {
        return $this->journals->count();
    }

    public function getUrlAttribute(): string
    {
        return "/clients/" . $this->id;
    }
}
