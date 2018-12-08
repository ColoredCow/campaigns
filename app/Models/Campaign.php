<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $guarded = [];

    public function subscriptionList()
    {
        return $this->belongsTo(SubscriptionList::class, 'subscription_list_id');
    }
}
