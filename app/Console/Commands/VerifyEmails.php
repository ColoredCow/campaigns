<?php

namespace App\Console\Commands;

use App\Helpers\EmailVerifier;
use App\Models\Subscriber;
use Illuminate\Console\Command;

class VerifyEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:verifyemails {--limit=5}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifies emails for subscribers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limit = $this->option('limit');
        $subscribers = Subscriber::whereNull('email_verification_at')->limit($limit)->get();
        foreach ($subscribers as $subscriber) {
            $verified = EmailVerifier::isValidEmail($subscriber->email);
            $subscriber->has_verified_email = $verified;
            $subscriber->email_verification_at = now();
            $subscriber->save();
        }
    }
}
