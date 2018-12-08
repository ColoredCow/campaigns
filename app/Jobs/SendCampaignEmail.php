<?php

namespace App\Jobs;

use App\Mail\SendCampaign;
use App\Models\Campaign;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendCampaignEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $subscriber;
    protected $campaign;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Subscriber $subscriber, Campaign $campaign)
    {
        $this->subscriber = $subscriber;
        $this->campaign = $campaign;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->subscriber->email, $this->subscriber->name)
            ->queue(new SendCampaign($this->campaign));
    }
}
