<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PendingEmail;
use App\Helpers\EmailVerifier;

class VerifyPendingEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaigns:verifypendingemails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifies emails in the pending queue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pendingEmails = PendingEmail::with('subscriber')->get();
        foreach ($pendingEmails as $pendingEmail) {
            $subscriber = $pendingEmail->subscriber;
            if($subscriber->has_verified_email){
                $verified = EmailVerifier::isValidEmail($subscriber->email);
                $subscriber->has_verified_email = $verified;
                $subscriber->email_verification_at = now();
                $subscriber->save();
            }
        }
    }
}
