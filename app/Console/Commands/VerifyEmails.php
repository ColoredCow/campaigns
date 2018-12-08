<?php

namespace App\Console\Commands;

use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Skmetaly\EmailVerifier\Facades\EmailVerifier;

class VerifyEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gf:verifyemails {--limit=5}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifies emails for subscribers';

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
        $subscribers = Subscriber::whereNull('email_verification_at')->limit($limit)->get();
        foreach ($subscribers as $subscriber) {
            $verified = EmailVerifier::verify($subscriber->email);
            $subscriber->has_verified_email = $verified;
            $subscriber->email_verification_at = Carbon::now();
            $subscriber->save();
        }
    }
}
