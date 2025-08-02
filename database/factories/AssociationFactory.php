<?php

namespace Database\Factories;

use App\Models\Association;
use App\Models\User;
use App\Models\Location;
use App\Models\Division;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssociationFactory extends Factory
{
    protected $model = Association::class;

    public function definition(): array
    {
        $cameroon = Country::where('code', 'CM')->firstOrFail();

        // Get village division IDs in Cameroon
        $villageDivisionIds = Division::where('type', 'village')
            ->where('country_id', $cameroon->id)
            ->pluck('id')
            ->toArray();

        // Pick a random village division ID
        $villageDivisionId = $this->faker->randomElement($villageDivisionIds);

        // Create a Location at that village division with Cameroon as country
        $location = Location::factory()->create([
            'country_id' => $cameroon->id,
            'division_id' => $villageDivisionId,
        ]);

        return [
            'name' => $this->faker->unique()->company . ' Association',
            'description' => $this->faker->optional()->realTextBetween(80, 180),

            // Assign the newly created location
            'location_id' => $location->id,

            // Assign creator user (existing or create new)
            //'creator_id' => User::inRandomOrder()->first()?->id ?? User::factory(),

            'status' => 1, // active
        ];
    }
}
