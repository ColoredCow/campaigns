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

		// add "all" category
        $allCategory = SubscriptionList::where('name', 'all')->first();
        $subscriber->lists()->syncWithoutDetaching($allCategory->id);

        if (isset($request['subscription_lists'])) {
            $subscriber->lists()->syncWithoutDetaching($request['subscription_lists']);
        }

        return $subscriber;
	}
}
