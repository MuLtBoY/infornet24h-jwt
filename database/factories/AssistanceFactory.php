<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assistance>
 */
class AssistanceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'status' => $this->faker->boolean(),
        ];
    }
}