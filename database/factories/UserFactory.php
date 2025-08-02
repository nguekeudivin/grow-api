<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Language;
use App\Models\Location;
use App\Models\Division;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        // Get Cameroon country ID
        $cameroon = Country::where('code', 'CM')->firstOrFail();

        // Get region division IDs for Cameroon
        $regionIds = Division::where('type', 'region')->where('country_id', $cameroon->id)->pluck('id')->toArray();

        // Get village division IDs for Cameroon
        $villageIds = Division::where('type', 'village')->where('country_id', $cameroon->id)->pluck('id')->toArray();

        // Create Location with region division and Cameroon as country
        $regionLocation = Location::factory()->create([
            'country_id' => $cameroon->id,
            'division_id' => $this->faker->randomElement($regionIds),
        ]);

        // Create Location with village division and Cameroon as country
        $villageLocation = Location::factory()->create([
            'country_id' => $cameroon->id,
            'division_id' => $this->faker->randomElement($villageIds),
        ]);

        return [
            // Identity Info
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->unique()->numerify('6########'),
            'password' => Hash::make('password'),

            // Profile
            'gender' => $this->faker->randomElement(['MALE', 'FEMALE']),
            'birth_date' => $this->faker->dateTimeBetween('-50 years', '2005-01-01')->format('Y-m-d'),
            'about' => $this->faker->optional()->paragraph(),

            // Verification
            'email_verified_at' => now(),
            'verified_at' => $this->faker->boolean(20) ? now() : null,

            // Tokens
            'remember_token' => Str::random(10),

            // Foreign keys
            'location_id' => $regionLocation->id,
            'origin_location_id' => $villageLocation->id,

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
