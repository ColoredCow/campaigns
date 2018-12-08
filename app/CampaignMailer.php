<?php

namespace App;

use App\Mail\SendCampaign;
use App\Models\Campaign;
use Illuminate\Support\Facades\Mail;

class CampaignMailer
{
    public function send($job, $data)
    {
        $campaign = Campaign::latest()->first();
        $subscriber = $data['subscriber'];
        Mail::to($subscriber['email'], $subscriber['name'])->send(new SendCampaign($campaign));
    }
}
