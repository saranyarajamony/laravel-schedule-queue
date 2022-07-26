<?php

namespace Database\Factories;

use App\Enums\ApplicationStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => $this->faker->randomELement([ApplicationStatus::Prelim,ApplicationStatus::Order]), 
            'queue' => 'default',
            'payload' => '',
            'attempts' => 1,
            'reserved_at' => 0
           
        ];
    }
}
