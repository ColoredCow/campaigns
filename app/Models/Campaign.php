<?php

namespace App\Models;

use App\Models\CampaignAttachment;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $guarded = [];

    public function subscriptionList()
    {
        return $this->belongsTo(SubscriptionList::class, 'subscription_list_id');
    }

    public function attachment()
    {
        return $this->hasMany(CampaignAttachment::class);
    }
}
