<?php

namespace Database\Seeders;

use App\Models\Assistance;
use App\Models\Purveyor;
use App\Models\PurveyorAssistance;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $assistances = Assistance::factory()->count(10)->create();

        $purveyors = Purveyor::factory()->count(25)->create();

        foreach ($purveyors as $purveyor) {
            $assistances->random(3)->each(function ($assistance) use ($purveyor) {
                PurveyorAssistance::factory()->create([
                    'purveyor_id' => $purveyor->id,
                    'assistance_id' => $assistance->id,
                ]);
            });
        }
        }
}
