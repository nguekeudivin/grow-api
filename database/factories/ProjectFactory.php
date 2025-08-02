<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Association;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->sentence(3),
            'description' => $this->faker->optional()->paragraph(2),
           // 'location_id' => Location::inRandomOrder()->first()?->id,
           // 'association_id' => Association::inRandomOrder()->first()?->id,
            'budget' => $this->faker->randomFloat(2, 500_000, 20_000_000),
            'status' => $this->faker->numberBetween(0, 3), // planned, ongoing, completed, cancelled
        ];
    }
}
