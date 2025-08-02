<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'association_member' => [
                'description' => 'A general user who can view and contribute to projects, and join associations',
                'name' => 'Member',
                'permissions' => [
                    'project.view',
                    'project.contribute',
                    'association.join',
                    'contribution.make',
                    'member.census_fill',
                ],
            ],
            'association_admin' => [
                'description' => 'A leader of a registered association, able to manage members and related projects',
                 'name' => 'Association admin',
                'permissions' => [
                    'association.create',
                    'association.update',
                    'association.view',
                    'association.manage_members',
                    'project.create',
                    'project.update',
                    'contribution.view',
                    'member.invite',
                    'project.create',
                    'project.update',
                    'project.manage_status',
                    'project.manage_funding',
                    'contribution.view',
                    'fundraising.manage_campaign',
                ],
            ],
            'project_owner' => [
                'name' => 'Project Owner',
                'description' => 'A person responsible for initiating and managing one or more community projects',
                'permissions' => [
                    'project.create',
                    'project.update',
                    'project.manage_status',
                    'project.manage_funding',
                    'contribution.view',
                    'fundraising.manage_campaign',
                ],
            ],
            'moderator' => [
                'name' => 'Moderator',
                'description' => 'A user who can help oversee and moderate content and activity within the platform',
                'permissions' => [
                    'project.view',
                    'contribution.view',
                    'association.view',
                    'member.view',
                ],
            ],
            'admin' => [
                'name' => 'Administrator',
                'description' => 'Full system access; manages users, roles, permissions, and platform configurations',
                'permissions' => Permission::pluck('name')->toArray(), // All permissions
            ],
        ];

        foreach ($roles as $code => $roleData) {
            $role = Role::firstOrCreate(
                ['code' => $code],
                ['description' => $roleData['description'], 'name' => $roleData['name']]
            );

            $permissions = Permission::whereIn('name', $roleData['permissions'])->get();
            $role->permissions()->sync($permissions->pluck('id'));
        }
    }
}
