<?php

namespace App\Services;

use App\Models\Subscriber;
use App\Models\SubscriptionList;

class SubscriberService
{
	public function store($request, $detachLists = true)
	{
		$subscriber = Subscriber::firstOrCreate([
            'email' => $request['email'],
        ], [
            'name' => $request['name'],
            'phone' => $request['phone'] ?? null,
            'has_verified_email' => true, // EmailVerifier::isValidEmail($request->post('email')),
            'email_verification_at' => now(),
        ]);

        $request['subscription_lists'] = $request['subscription_lists'] ?? [];
        $allList = SubscriptionList::where('name', 'all')->first();
        array_push($request['subscription_lists'], $allList->id); // add subscriber to "all" list
        if ($detachLists) {
            $subscriber->lists()->sync($request['subscription_lists']);
        } else {
            $subscriber->lists()->syncWithoutDetaching($request['subscription_lists']);
        }

        return $subscriber;
	}

    public function update($subscriber, $request, $detachLists = true)
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
        if ($detachLists) {
            $subscriber->lists()->sync($request['subscription_lists']);
        } else {
            $subscriber->lists()->syncWithoutDetaching($request['subscription_lists']);
        }

        return $subscriber;
    }
}
