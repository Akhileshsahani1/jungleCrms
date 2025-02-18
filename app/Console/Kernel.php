<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands = [
        Commands\ReminderCron::class,
    ];
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('rabbitmq:consume')->runInBackground();
        // $schedule->command('inspire')->hourly();
        $schedule->command('reminder:cron');
        $schedule->command('refund:check')->everyFiveMinutes();
        // $schedule->command('reminder:cron')
        //          ->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
