<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * 
     * The Artisan command provided by the application
     */

    protected $commands = [
        Commands\ProcessApplicationCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected function schedule(Schedule $schedule)
    {

        // $schedule->command('nbnApplications:schedule')->everyFiveMinutes();
       $schedule->command('nbnApplications:schedule')->everyMinute();

        // call queue:work artisan command to dispatch the job
      // $schedule->command('queue:work --stop-when-empty')->everyTwoMinutes();
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
