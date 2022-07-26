<?php

namespace Tests\Unit;

use Illuminate\Console\Events\ScheduledTaskFinished;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

use Tests\TestCase;


class SchedulerTest extends TestCase
{
    use RefreshDatabase;

   /**
    * Test by running the schedule command 
    */
     public function test_command()
    {

        Event::fake();
        $this->travelTo(now()->startOfWeek()->setHour(9)->setMinute(30));
        $this->artisan('schedule:run');

        Event::assertDispatched(ScheduledTaskFinished::class, function ($event) {
            return strpos($event->task->command, 'nbnApplications:schedule') !== false;
        });
    } 
   

}
