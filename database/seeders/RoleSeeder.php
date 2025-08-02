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
            'member' => [
                'description' => 'A general user who can view and contribute to projects, and join associations',
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
                'permissions' => [
                    'association.create',
                    'association.update',
                    'association.view',
                    'association.manage_members',
                    'project.create',
                    'project.update',
                    'contribution.view',
                    'member.invite',
                ],
            ],
            'project_owner' => [
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
                'description' => 'A user who can help oversee and moderate content and activity within the platform',
                'permissions' => [
                    'project.view',
                    'contribution.view',
                    'association.view',
                    'member.view',
                ],
            ],
            'admin' => [
                'description' => 'Full system access; manages users, roles, permissions, and platform configurations',
                'permissions' => Permission::pluck('name')->toArray(), // All permissions
            ],
        ];

        foreach ($roles as $name => $roleData) {
            $role = Role::firstOrCreate(
                ['name' => $name],
                ['description' => $roleData['description']]
            );

            $permissions = Permission::whereIn('name', $roleData['permissions'])->get();
            $role->permissions()->sync($permissions->pluck('id'));
        }
    }
}
