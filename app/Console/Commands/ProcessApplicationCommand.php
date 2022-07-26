<?php

namespace App\Console\Commands;

use App\Enums\ApplicationStatus;
use App\Jobs\ApplicationsJob;
use App\Models\Application;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessApplicationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nbnApplications:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to find yet to be proccessed nbn applications every five minutes';

    /**
     * Execute the console command.
     * 
     *  Find out the unprocessed nbn applications
     *  call dispatch method on every job of each application 
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting to dispatch job');
        try {
            $nbnApplications = Application::whereHas('plan', function ($plan) {
                $plan->where('type', '=', 'nbn');
            })->where('status', '=', ApplicationStatus::Order)->get();

            $this->info('dispatching job for every application...');            

           collect($nbnApplications)->each(fn($application) => dispatch(new ApplicationsJob($application->id))); 
        }
        catch (\Exception $e) {
            Log::info($e);
        }
        
    }
}
