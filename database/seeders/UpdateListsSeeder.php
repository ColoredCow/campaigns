<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use App\Models\SubscriptionList;
use Illuminate\Database\Seeder;

class UpdateListsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$sukhanEmails = Subscriber::whereHas('lists', function($query) {
            $query->where('name', 'like', 'sukhan%');
        })
        ->with('lists')
        ->get();

        $solarId =  SubscriptionList::where('name', 'solar')->pluck('id')->first();
        $sukhanIds =  SubscriptionList::where('name', 'like', 'sukhan%')->pluck('id');

        foreach ($sukhanEmails as $sukhanEmail) {

            $sukhanEmail->lists()->detach($sukhanIds);
            
            $lists = $sukhanEmail->lists->pluck('id')->toArray(); 
            if (!in_array($solarId, $lists)) {
                $sukhanEmail->lists()->attach($solarId);
            }
        }
        SubscriptionList::whereIn('id', $sukhanIds)->delete();
    }
}
