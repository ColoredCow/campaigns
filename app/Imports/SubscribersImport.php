<?php

namespace App\Imports;

use App\Models\FailedUpload;
use App\Models\Subscriber;
use App\Models\SubscriptionList;
use App\Services\SubscriberService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubscribersImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $service = new SubscriberService;

        foreach ($rows as $row) 
        {
            if (!isset($row['email']) || !isset($row['name'])) {
                continue;
            }

            // if email is not a valid email
            if (!filter_var($row['email'], FILTER_VALIDATE_EMAIL)) {
                FailedUpload::create([
                    'file' => request()->file('file')->getClientOriginalName(),
                    'data' => json_encode($row->toArray()),
                ]);
                continue;
            }

            $subscriptionList = SubscriptionList::firstOrCreate(['name' => request()->input('category')]);
            $row['subscription_lists'] = [$subscriptionList->id];

            $subscriber = $service->store($row->toArray(), false);

            if (is_null($subscriber->phone) && !empty($row['phone'])) {
                $subscriber->update([
                    'phone' => $row['phone'],
                ]);
            }
        }
    }
}
