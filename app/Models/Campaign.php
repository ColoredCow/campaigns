<?php

namespace App\Models;

use App\Models\Attachment;
use App\Models\SenderIdentity;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $guarded = [];

    public function subscriptionList()
    {
        return $this->belongsTo(SubscriptionList::class, 'subscription_list_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'resource');
    }

    public function senderIdentity()
    {
        return $this->hasOne(SenderIdentity::class, 'id', 'sender_identity_id')->withTrashed();
    }

    public function getSenderIdentityNameAttribute()
    {
        return $this->senderIdentity ? $this->senderIdentity->name : config('constants.campaigns.from.name');
    }

    public function getSenderIdentityEmailAttribute()
    {
        return $this->senderIdentity ? $this->senderIdentity->email : config('constants.campaigns.from.email');
    }
}
