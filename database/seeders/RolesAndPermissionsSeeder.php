<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'create genres', 'read genres', 'update genres', 'delete genres',
            'create users', 'read users', 'update users', 'delete users',
            'read user_profiles',
            'assign roles', 'read roles' , 'assign permissions', 'revoke permissions',
            'create directors', 'read directors', 'update directors', 'delete directors',
            'create movies', 'read movies', 'update movies', 'delete movies',
            'create ratings', 'read ratings', 'update ratings', 'delete ratings',
            'create reviews', 'read reviews', 'update reviews', 'delete reviews',
        ];

        // Save permissions to database
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $moderatorRole = Role::firstOrCreate(['name' => 'moderator']);
        $reviewerRole = Role::firstOrCreate(['name' => 'reviewer']);

        //Assign permissions to roles
        $adminRole->givePermissionTo($permissions);

        $moderatorRole->givePermissionTo([
            'read genres', 'read users', 'update users', 'delete users',
            'read user_profiles',
            'read directors', 'update directors', 'read movies', 'update movies',
            'read ratings', 'delete ratings',
            'read reviews', 'update reviews', 'delete reviews',
        ]);

        $reviewerRole->givePermissionTo([
            'read genres', 'read users', 'read user_profiles',
            'read directors', 'read movies',
            'create ratings', 'read ratings', 'update ratings', 'delete ratings',
            'create reviews', 'read reviews', 'update reviews', 'delete reviews',
        ]);
    }
}
