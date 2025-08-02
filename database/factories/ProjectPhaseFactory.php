<?php

namespace Database\Factories;

use App\Models\ProjectPhase;
use App\Models\Project;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectPhaseFactory extends Factory
{
    protected $model = ProjectPhase::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Feasibility Study',
                'Community Mobilization',
                'Construction Phase 1',
                'Infrastructure Setup',
                'Monitoring & Evaluation',
            ]),
            'description' => $this->faker->optional()->paragraph(),
            'budget' => $this->faker->randomFloat(2, 100_000, 5_000_000),
            'status' => $this->faker->numberBetween(0, 2), // pending, in_progress, completed
        ];
    }
}
