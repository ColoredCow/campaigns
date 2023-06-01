<?php

namespace App\Services;

use App\Models\Subscriber;
use App\Models\SubscriptionList;
use App\Models\ListSubscriber;

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

    public function addSubscriber($data)
    {
        $existingSubscriber = Subscriber::where("email", $data["email"])->exists();
        if (!$existingSubscriber) {
            Subscriber::create([
                "name" => $data["name"],
                "email" => $data["email"],
                "phone" => $data["phone"],
                "has_verified_email" => 1,
                "email_verification_at" => now(),
            ]);
        }

        foreach ($data["subscription_lists"] as $list) {
            $this->addSubscriberToList($list, $data["email"]);
        }
    }

    public function addSubscriberToList($list, $email) {
        $existingList = SubscriptionList::where("name", $list)->first();
        $subscriber = Subscriber::where("email", $email)->first();

        if ($existingList) {
            $listSubscriber = ListSubscriber::where("subscriber_id", $subscriber->id)->first();

            if (!$listSubscriber) {
                $this->addingSubscriberToList($existingList->id, $subscriber->id);
            }

        } else {
            SubscriptionList::create([
                "name" => $list,
            ]);

            $list = SubscriptionList::where("name", $list)->first();
            $this->addingSubscriberToList($list->id, $subscriber->id);
        }
        return;
    }

    public function addingSubscriberToList($listid, $subscriberId) {
        ListSubscriber::insert([
            "list_id" => $listid,
            "subscriber_id" =>$subscriberId,
        ]);
    }
}
