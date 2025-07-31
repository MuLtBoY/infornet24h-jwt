<?php

namespace Database\Factories;

use App\Models\Assistance;
use App\Models\Purveyor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurveyorAssistance>
 */
class PurveyorAssistanceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'purveyor_id' => Purveyor::inRandomOrder()->first()->id ?? Purveyor::factory(),
            'assistance_id' => Assistance::inRandomOrder()->first()->id ?? Assistance::factory(),
            'start_km' => $this->faker->numberBetween(0, 100),
            'start_value' => $this->faker->randomFloat(2, 50, 500),
            'value_km' => $this->faker->randomFloat(2, 1, 10),
        ];
    }
}