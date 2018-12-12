<?php

namespace App\Console\Commands;

use App\Helpers\EmailVerifier;
use App\Models\PendingEmail;
use Carbon\Carbon;
use Illuminate\Console\Command;

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
        $pendingEmails = PendingEmail::with('subscriber')->get();
        foreach ($pendingEmails as $pendingEmail) {
            $subscriber = $pendingEmail->subscriber;
            if ($subscriber->has_verified_email) {
                $verified = EmailVerifier::isValidEmail($subscriber->email);
                $subscriber->has_verified_email = $verified;
                $subscriber->email_verification_at = Carbon::now();
                $subscriber->save();
            }
        }
    }
}
