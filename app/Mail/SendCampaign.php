<?php

namespace App\Mail;

use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendCampaign extends Mailable
{
    use Queueable, SerializesModels;

    protected $campaign;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from(config('constants.campaigns.from.email'), config('constants.campaigns.from.name'))
            ->subject($this->campaign->email_subject)
            ->view('emails.plain')
            ->with([
                'body' => $this->campaign->email_body,
            ]);

        if (!is_null($this->campaign->attachment)) {
            // $this->attach(storage_path('app/' . $this->campaign->attachment));
        }

        return $this;
    }
}
