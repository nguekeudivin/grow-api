<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Plan;
use App\Models\City;
use App\Models\Subscription;
use App\Models\Area;
use App\Models\Interest;
use App\Models\UserLanguage;
use App\Models\Language;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();
        DB::table('subscriptions')->delete();
        DB::table('images')->delete();

        $faker = Faker::create();
        $citiesIds = City::pluck('id')->toArray();
        $areas = Area::pluck('area_name')->toArray();
        $plansIds = Plan::pluck('id')->toArray();
        $interestsIds = Interest::pluck('id')->toArray();
        $languagesIds = Language::pluck('id')->toArray();

        // Loop 20 times to create 20 users
        for ($i = 0; $i < 20; $i++) {
            $user = User::create([
                'email' => $faker->unique()->safeEmail(),
                'password' => \Illuminate\Support\Facades\Hash::make('password'), // Hash a default password
                'email_verified_at' => now(),
                'firstname' => $faker->firstName(),
                'lastname' => $faker->lastName(),
                'birth_date' => $faker->date('Y-m-d', '2005-01-01'), // Dates up to 2005
                'gender' => $faker->randomElement(['MALE', 'FEMALE']),
                 'phone_number' => $faker->numerify('6########'),
                'city_id' => $faker->randomElement($citiesIds),
                'is_online' => $faker->boolean(50),
                'last_online' => $faker->date('Y-m-d', '2025-06-30 12:15'),
                'area' => $faker->randomElement($areas),
                'lang' => $faker->randomElement(['en', 'fr']),
                'about' => $faker->paragraph(3, true),
                'looking' => $faker->sentence(),
                'verified_at' => $faker->boolean(20) ? now() : null,
                'occupation' => $faker->jobTitle(),
            ]);

            // Create a subscription for the user.
            Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $faker->randomElement($plansIds),
                "expired_at" => Carbon::now()->addDays(1000),
            ]);

            // Create Interest the users.
            shuffle($interestsIds); // Randomize the order of elements
            $user->interests()->sync(array_slice($interestsIds, 0, 3));

            // Create a profile image for the user.
            $imagePath = '/images/image-'. $faker->numberBetween(1, 15).'.jpg';
            $user->image()->create([
                'url' => url($imagePath),
                'path' => $imagePath,
                'imageable_type' => User::class,
                'imageable_id' => $user->id
            ]);

            // Attribute a language to the user.
            UserLanguage::create([
                'user_id' => $user->id,
                'language_id' => $faker->randomElement($languagesIds)
            ]);
        }
    }
}
