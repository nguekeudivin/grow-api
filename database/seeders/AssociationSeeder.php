<?php

namespace Database\Seeders;

use App\Models\Association;
use App\Models\AssociationUser;
use App\Models\AssociationUserRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssociationSeeder extends Seeder
{
    public function run(): void
    {
        // Disable FK checks for truncate safety
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('association_user_roles')->truncate();
        DB::table('association_users')->truncate();
        DB::table('associations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $users = User::all();

        $adminRole = Role::where('code', 'association_admin')->firstOrFail();
        $memberRole = Role::where('code', 'association_member')->firstOrFail();

        foreach ($users as $user) {
            // Create an association for each user
            $association = Association::factory()->create([
                'creator_id' => $user->id,
            ]);

            // Link creator to association
            $creatorAssociationUser = AssociationUser::create([
                'user_id' => $user->id,
                'association_id' => $association->id,
            ]);

            // Assign both admin and member roles to the creator
            AssociationUserRole::create([
                'association_user_id' => $creatorAssociationUser->id,
                'role_id' => $memberRole->id,
            ]);

            AssociationUserRole::create([
                'association_user_id' => $creatorAssociationUser->id,
                'role_id' => $adminRole->id,
            ]);

            // Pick 10 other users (excluding creator)
            $otherUsers = $users->where('id', '!=', $user->id);
            if ($otherUsers->count() > 10) {
                $otherUsers = $otherUsers->random(10);
            }

            foreach ($otherUsers as $otherUser) {
                $member = AssociationUser::create([
                    'user_id' => $otherUser->id,
                    'association_id' => $association->id,
                ]);

                AssociationUserRole::create([
                    'association_user_id' => $member->id,
                    'role_id' => $memberRole->id,
                ]);
            }
        }
    }
}
