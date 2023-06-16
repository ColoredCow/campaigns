<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\SenderIdentity;
use App\Models\Subscriber;
use App\Models\SubscriptionList;

class CampaignService
{
	public function create($request)
	{
		$response = [
			'allSubscribersCount' => Subscriber::count(),
	        'allListId' => optional(SubscriptionList::where('name', 'like', 'all')->first())->id,
	        'lists' => SubscriptionList::withCount('subscribers')->orderBy('name')->get(),
	        'senderIdentities' => SenderIdentity::all(),
		];

		$response['lists'] = $response['lists']->sortBy(function ($list) {
			return $list->name !== 'all';
		});

		if ($request->input('duplicate')) {
			// TODO: validation
			$response['duplicateCampaign'] = Campaign::with('subscriptionList')->find($request->input('duplicate'));
		}

		return $response;
	}

    public function show(Campaign $campaign)
    {
    	$campaign->load('subscriptionList');
        return [
        	'campaign' => $campaign,
        ];
    }
}
