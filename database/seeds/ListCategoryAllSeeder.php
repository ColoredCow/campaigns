<?php

use App\Models\Subscriber;
use App\Models\SubscriptionList;
use Illuminate\Database\Seeder;

class ListCategoryAllSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $listCategoryAll = SubscriptionList::firstOrCreate([
            'name' => 'all',
        ]);

        $emails = Subscriber::all();

        foreach ($emails as $email) {
            if ($email->lists()->where('id', $listCategoryAll->id)->doesntExist()) {
                $email->lists()->attach($listCategoryAll->id);
            }
        }
    }
}
