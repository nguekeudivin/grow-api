<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LanguageSeeder::class,
            LocationSeeder::class,
            InterestSeeder::class,
            PlanSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            ServiceSeeder::class,
            PostSeeder::class,
            TicketCategorySeeder::class,
            TicketSeeder::class,
            ReportSeeder::class,
            PaymentSeeder::class,
            SettingSeeder::class
        ]);
    }
}
