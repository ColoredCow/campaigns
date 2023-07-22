<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'subscription_list_id',
        'sender_identity_id',
        'email_subject',
        'email_body',
    ];

    public $senderIdentity;

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'subscription_list_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'resource');
    }

    public function senderIdentity()
    {
        return $this->hasOne(SenderIdentity::class, 'id', 'sender_identity_id');
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
