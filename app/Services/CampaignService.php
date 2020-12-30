<?php

namespace App\Services;

use App\Models\Campaign;

class CampaignService
{
    public function show(Campaign $campaign)
    {
    	$campaign->load('subscriptionList');
        return [
        	'campaign' => $campaign,
        ];
    }
}
