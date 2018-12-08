<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('campaigns:verifyemails --limit=6')
            ->everyMinute()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/email-verification.log'));

        $schedule->command('campaigns:sendpendingemails --limit=30')
            ->everyMinute()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/sent-emails.log'));

        $schedule->command('campaigns:verifypendingemails')
            ->daily()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/verify-pending-emails.log'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
