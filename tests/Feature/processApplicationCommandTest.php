<?php

namespace Tests\Unit;

use App\Jobs\ApplicationsJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use Illuminate\Foundation\Bus\DispatchesJobs;

class ProcessApplicationCommandTest extends TestCase
{
  use RefreshDatabase;
  use DispatchesJobs;

  /**
   * Test if the command call reaches the handle method to run the dispatch
   * 
   */
  public function testCommand()
  {

    $this->artisan('nbnApplications:schedule')->expectsOutput('Starting to dispatch job');
  }

  /**
   * Test if the queues dispatched and pushed 
   */
  public function test_it_queues()
  {
    Queue::fake();
    $job = new ApplicationsJob(1);
    Queue::push($job);
    $this->dispatch($job);
    $queueSize = Queue::size();
    Queue::assertPushed(ApplicationsJob::class, $queueSize);
  }

  /**
   * Pending test case--- check if the handle method from Application job after updating the table post the request
   */
}
