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
    protected $signature = 'gf:sendpendingemails {--limit=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends emails in pending_emails table. Deletes the entry after sending.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $limit = $this->option('limit');
        $pendingEmails = PendingEmail::with(['subscriber', 'campaign'])->limit($limit)->get();
        foreach ($pendingEmails as $pendingEmail) {
            $subscriber = $pendingEmail->subscriber;
            $campaign = $pendingEmail->campaign;
            Mail::to($subscriber->email, $subscriber->name)->send(new SendCampaign($campaign));
            CampaignEmailsSent::create([
                'subscriber_id' => $subscriber->id,
            ]);
            $pendingEmail->delete();
            usleep(100000);
        }
    }
}
