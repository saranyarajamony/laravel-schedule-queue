<?php

namespace App\Jobs;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;


class ApplicationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // number of times the job may be attempted
    public $tries = 5;

    // max num of unhandled exception to allow before failing
    public $maxExceptions = 3;

    // job is considered as failed on timeout
    public $failOnTimeout = true;

    // num of sec the job can run before timing out
    public $timeout = 10;

    // num of sec to wait before reattempting the job
    public $backoff = 3;

    public $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public int $applicationId)
    {
    }

    /**
     * Execute the job.
     * 
     *  write join queries to get applications under nbn with status = order and plan type = nbn
     *   if success => 1) update application table = orderId (randomnumber) and starus = complete
    *                2)send a response to b2b endpoint with a success.json
     *   if failure => 1) retry after sometime , no change to application table
     *                 2)send a reponse to b2b endpoint with failure.json
     *
     * @return void
     */
    public function handle()
    {      

        $updateApplication = Application::find($this->applicationId);
        $updateApplication->order_id = rand(0, 9999);
        $updateApplication->status = ApplicationStatus::Complete;
        if (!$updateApplication->save()) {
            $jsonString = file_get_contents(base_path('resources/lang/en/json/application-fail.json'));
        } else {
            $jsonString = file_get_contents(base_path('resources/lang/en/json/application-success.json'));
        }


        $data = json_decode($jsonString, true);

        //update data
        $data['id'] = $updateApplication->order_id;
        $data['status'] = $updateApplication->status;
        $data['dispatchDetails']['deliveryToAddress']['addressLine1'] = $updateApplication->address_1;
        $data['dispatchDetails']['deliveryToAddress']['addressLine2'] = $updateApplication->address_2;
        $data['dispatchDetails']['deliveryToAddress']['localityName'] = $updateApplication->city;
        $data['dispatchDetails']['deliveryToAddress']['stateTerritoryCode'] = $updateApplication->state;
        $data['dispatchDetails']['deliveryToAddress']['postCode'] = $updateApplication->postcode;
  
        //trying to send the response to a third party

        $response = Http::withToken('31|14gfAJHaXv6qU3x4WwxAwE8Txxxxxxxxxxxxxxxx')
            ->post(env('NBN_B2B_ENDPOINT'), $data)
            ->throw()
            ->json();
    }
}
