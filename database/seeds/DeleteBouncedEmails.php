<?php

use App\Models\CampaignEmailsSent;
use App\Models\PendingEmail;
use App\Models\Subscriber;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeleteBouncedEmails extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bouncedEmails = DB::table('bounced_emails')->get();

        foreach ($bouncedEmails as $bouncedEmail) {
	        $subscriber = Subscriber::with('lists')->where('email', $bouncedEmail->email)->first();
	        if (!$subscriber) {
	        	continue;
	        }
	        CampaignEmailsSent::where('subscriber_id', $subscriber->id)->delete();
	        PendingEmail::where('subscriber_id', $subscriber->id)->delete();
	        $subscriber->lists()->detach();
	        $subscriber->delete();
        }
    }
}
