<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subscriber extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'is_subscribed',
    ];

    protected $casts = [
        'email_verification_at' => 'datetime',
        'has_verified_email' => 'boolean',
        'is_subscribed' => 'boolean',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['tags'];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'list_subscriber', 'subscriber_id', 'list_id');
    }

    public function scopeHasVerifiedEmail($query)
    {
        return $query->where('has_verified_email', true);
    }

    public function scopeHasRefutedEmail($query)
    {
        return $query->where('has_verified_email', false);
    }
}
