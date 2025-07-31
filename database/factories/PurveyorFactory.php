<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purveyor>
 */
class PurveyorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'street' => $this->faker->streetName(),
            'neighborhood' => $this->faker->citySuffix(),
            'number' => $this->faker->buildingNumber(),
            'latitude' => $this->faker->latitude(-30, -15),
            'longitude' => $this->faker->longitude(-60, -40),
            'city' => $this->faker->city(),
            'uf' => strtoupper($this->faker->lexify('??')),
        ];
    }
}