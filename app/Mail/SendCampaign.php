<?php

namespace App\Mail;

use App\Models\Campaign;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Helpers\ParseEmailTemplate;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Queue\SerializesModels;

class SendCampaign extends Mailable
{
    use Queueable, SerializesModels;

    protected $campaign;
    protected $subscriber;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Campaign $campaign, Subscriber $subscriber)
    {
        $this->campaign = $campaign;
        $this->subscriber = $subscriber;
        $this->mailBody = ParseEmailTemplate::emailTemplateVariables($this->subscriber, $this->campaign->email_body);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $from = $this->getFrom();
        $email = $this->to($this->subscriber->email, $this->subscriber->name)
            ->from($from['email'], $from['name'])
            ->subject($this->campaign->email_subject)
            ->view('emails.plain')
            ->with([
                'body' => $this->mailBody,
                'encryptedSubscriberId' => Crypt::encrypt($this->subscriber->id),
            ]);
        if ($this->campaign->attachments->count() > 0) {
            foreach ($this->campaign->attachments as $attachment) {
                $email->attach(storage_path('app/' . $attachment->attachment));
            }
        }
        return $this;
    }

    private function getFrom()
    {
        if (!$this->campaign->senderIdentity) {
            return [
                'name' => config('constants.campaigns.from.name'),
                'email' => config('constants.campaigns.from.email'),
            ];
        }

        return [
            'name' => $this->campaign->sender_identity_name,
            'email' => $this->campaign->sender_identity_email,
        ];
    }
}
