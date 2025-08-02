<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Project
            ['name' => 'project.view', 'description' => 'View available development projects in the community'],
            ['name' => 'project.create', 'description' => 'Create a new community or association project'],
            ['name' => 'project.update', 'description' => 'Edit project details like title, description, dates'],
            ['name' => 'project.delete', 'description' => 'Remove a project (soft delete or archive)'],
            ['name' => 'project.manage_status', 'description' => 'Update the project status (e.g., draft, active, completed)'],
            ['name' => 'project.manage_funding', 'description' => 'Define or change fundraising goals and budgets'],
            ['name' => 'project.contribute', 'description' => 'Participate in a project via contributions or volunteering'],

            // Contributions & Fundraising
            ['name' => 'contribution.view', 'description' => 'View all contributions for a specific project'],
            ['name' => 'contribution.make', 'description' => 'Make a financial/material contribution to a project'],
            ['name' => 'contribution.manage', 'description' => 'Approve, reject, or edit user contributions'],
            ['name' => 'fundraising.manage_campaign', 'description' => 'Start or modify fundraising campaigns'],
            ['name' => 'fundraising.view_reports', 'description' => 'View detailed reports on contributions and fundraising stats'],

            // Associations
            ['name' => 'association.create', 'description' => 'Create and register a new community association'],
            ['name' => 'association.update', 'description' => 'Update details of an existing association'],
            ['name' => 'association.delete', 'description' => 'Delete or archive an association'],
            ['name' => 'association.view', 'description' => 'View a list of registered associations'],
            ['name' => 'association.manage_members', 'description' => 'Add or remove members from an association'],
            ['name' => 'association.join', 'description' => 'Join an existing association as a member'],

            // Member & Census
            ['name' => 'member.view', 'description' => 'View members in a project or association'],
            ['name' => 'member.invite', 'description' => 'Invite new users to join a project or association'],
            ['name' => 'member.remove', 'description' => 'Remove a member from a group or role'],
            ['name' => 'member.census_fill', 'description' => 'Complete or update personal census data'],
            ['name' => 'member.census_manage', 'description' => 'View, export, or edit census and demographic data'],

            // Admin
            ['name' => 'admin.dashboard_access', 'description' => 'Access the admin dashboard and analytics'],
            ['name' => 'admin.manage_users', 'description' => 'Create, update, suspend, or delete user accounts'],
            ['name' => 'admin.manage_roles', 'description' => 'Assign or revoke roles to/from users'],
            ['name' => 'admin.manage_permissions', 'description' => 'Create or modify permission sets'],
            ['name' => 'admin.view_audit_logs', 'description' => 'View logs of critical platform events and actions'],
            ['name' => 'admin.manage_settings', 'description' => 'Change global platform settings and preferences'],
        ];

        foreach ($permissions as $data) {
            Permission::firstOrCreate(
                ['name' => $data['name']],
                ['description' => $data['description']]
            );
        }
    }
}
