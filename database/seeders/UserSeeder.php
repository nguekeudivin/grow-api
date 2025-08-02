<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Language;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to safely truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('user_languages')->truncate();
        DB::table('users')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Fetch all language IDs
        $languageIds = Language::pluck('id')->toArray();

        // Create 20 users
        User::factory()
            ->count(20)
            ->create()
            ->each(function ($user) use ($languageIds) {
                // Assign one random language to each user
                $user->languages()->attach(
                    fake()->randomElement($languageIds)
                );
            });
    }
}
