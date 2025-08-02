<?php

namespace Database\Seeders;

use App\Models\Association;
use App\Models\Project;
use App\Models\ProjectPhase;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks for safe deletion
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('project_phases')->truncate();
        DB::table('projects')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $associations = Association::all();

        foreach ($associations as $association) {
            // Create 2 projects per association using association's location_id
            $projects = Project::factory()
                ->count(2)
                ->create([
                    'association_id' => $association->id,
                    'location_id' => $association->location_id, // Use association location here
                ]);

            // Create between 2 and 5 phases per project
            foreach ($projects as $project) {
                $phaseCount = rand(2, 5);

                for ($i = 1; $i <= $phaseCount; $i++) {
                    \App\Models\ProjectPhase::factory()->create([
                        'project_id' => $project->id,
                        'order' => $i,
                        'location_id' => $project->location_id,
                    ]);
                }
            }
        }
    }
}
