<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        return [
            'city' => $this->faker->optional()->city(),
            'street' => $this->faker->optional()->streetAddress(),
            'postal_code' => $this->faker->optional()->postcode(),
            'latitude' => $this->faker->optional()->latitude(2.0, 13.0),
            'longitude' => $this->faker->optional()->longitude(8.0, 16.0),
        ];
    }
}
