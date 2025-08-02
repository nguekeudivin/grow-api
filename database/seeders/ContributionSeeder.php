<?php

namespace Database\Seeders;

use App\Models\Association;
use App\Models\Contribution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContributionSeeder extends Seeder
{
    public function run(): void
    {
        // Disable FK checks to safely truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Contribution::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get all user-association relationships
        $userAssociations = DB::table('association_users')->get();

        foreach ($userAssociations as $ua) {
            $userId = $ua->user_id;
            $association = Association::with('projects')->find($ua->association_id);

            if (!$association || $association->projects->isEmpty()) {
                continue;
            }

            foreach ($association->projects as $project) {
                Contribution::create([
                    'project_id' => $project->id,
                    'user_id' => $userId,
                    'payment_id' => null,
                    'amount' => rand(10_000, 1_000_000),
                    'status' => 1, // completed
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
