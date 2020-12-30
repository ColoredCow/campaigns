<?php

namespace App\Services;

use App\Models\Subscriber;
use App\Models\SubscriptionList;

class SubscriberService
{
	public function store($request)
	{
		$subscriber = Subscriber::firstOrCreate([
            'email' => $request['email'],
        ], [
            'name' => $request['name'],
            'phone' => $request['phone'] ?? '',
            'has_verified_email' => true, // EmailVerifier::isValidEmail($request->post('email')),
            'email_verification_at' => now(),
        ]);

        $request['subscription_lists'] = $request['subscription_lists'] ?? [];
        $allList = SubscriptionList::where('name', 'all')->first();
        array_push($request['subscription_lists'], $allList->id); // add subscriber to "all" list
        $subscriber->lists()->sync($request['subscription_lists']);

        return $subscriber;
	}

    public function update($subscriber, $request)
    {
        $subscriber->load('lists');
        $subscriber->update([
            'email' => $request['email'],
            'name' => $request['name'],
            'phone' => $request['phone'] ?? '',
        ]);

        $request['subscription_lists'] = $request['subscription_lists'] ?? [];
        $allList = SubscriptionList::where('name', 'all')->first();
        array_push($request['subscription_lists'], $allList->id); // add subscriber to "all" list
        $subscriber->lists()->sync($request['subscription_lists']);

        return $subscriber;
    }
}
