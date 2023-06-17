<?php

namespace App\Models;

use App\Models\SubscriptionList;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $guarded = [];

    protected $casts = [
        'email_verification_at' => 'datetime',
    ];

    public function lists()
    {
        return $this->belongsToMany(SubscriptionList::class, 'list_subscriber', 'subscriber_id', 'list_id');
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
