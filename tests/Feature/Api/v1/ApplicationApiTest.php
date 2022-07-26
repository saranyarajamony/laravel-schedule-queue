<?php

namespace Tests\Feature\Api\v1\Comment;


use App\Models\Application;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApplicationApiTest extends TestCase
{
    use RefreshDatabase;

    protected $uri = ['/api/v1/applications','/api/v1/applications?plan_type=mobile'];

    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->make();
        Sanctum::actingAs($user,['*']);
    }

    public function test_index()
    {
        // load data in db
        $applications = Application::factory(10)->create(); 
        $applicationsIds = $applications->map(fn($application) => $application->id);
 
        // call index endpoint
        $response = $this->json('get', $this->uri[0]);

        // assert status
        $response->assertStatus(200);

        // verify records
        $data = $response->json('data');

        collect($data)->each(fn($application) => $this->assertTrue(in_array($application['Application Id'], $applicationsIds->toArray()))); 
    }

    public function test_index_filter()
    {
        // load data in db
        $insertPlans = Plan::factory(10)->create();
        $applications = Application::factory(10)->create(); 

        // call index endpoint
        $response = $this->json('get', $this->uri[1]);

        // assert status
        $response->assertStatus(200);

        // verify records
        $data = $response->json('data');

        collect($data)->each(fn($application) => $this->assertSame($application['Plan']['Plan Type'],'mobile')); 
  }
}
