<?php

namespace App\Console\Commands;

use App\Mail\SendCampaign;
use App\Models\CampaignEmailsSent;
use App\Models\PendingEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendPendingEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:sendpendingemails {--limit=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends emails in pending_emails table. Deletes the entry after sending.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limit = (int)$this->option('limit');

        $pendingEmails = PendingEmail::with(['subscriber', 'campaign'])->limit($limit)->get();
        foreach ($pendingEmails as $pendingEmail) {
            $subscriber = $pendingEmail->subscriber;
            $campaign = $pendingEmail->campaign;
            Mail::queue(new SendCampaign($campaign, $subscriber));
            CampaignEmailsSent::create([
                'subscriber_id' => $subscriber->id,
            ]);
            $pendingEmail->delete();
            usleep(100000); // 0.1 seconds
        }
    }
}
