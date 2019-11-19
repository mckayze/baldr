<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Dashboard
         */
        Permission::create(['name' => 'View Dashboard Page', 'for' => 'dashboard']);
        Permission::create(['name' => 'View Dashboard Metrics', 'for' => 'dashboard']);

        /**
         * Users
         */
        Permission::create(['name' => 'View All Users Page', 'for' => 'users']);
        Permission::create(['name' => 'View Other User Profiles', 'for' => 'users']);
        Permission::create(['name' => 'View Own User Profile', 'for' => 'users']);
        Permission::create(['name' => 'Create Users', 'for' => 'users']);
        Permission::create(['name' => 'Edit Users', 'for' => 'users']);
        Permission::create(['name' => 'Delete Users', 'for' => 'users']);

        /**
         * Roles
         */
        Permission::create(['name' => 'View All Roles Page', 'for' => 'roles']);
        Permission::create(['name' => 'Create Roles', 'for' => 'roles']);
        Permission::create(['name' => 'Edit Roles', 'for' => 'roles']);
        Permission::create(['name' => 'Delete Roles', 'for' => 'roles']);

        /**
         * Media Manager
         */
        Permission::create(['name' => 'View Media Manager', 'for' => 'media']);

        /**
         * Posts
         */
        Permission::create(['name' => 'View All Posts Page', 'for' => 'posts']);
        Permission::create(['name' => 'Create Posts', 'for' => 'posts']);
        Permission::create(['name' => 'Post Without Permission', 'for' => 'posts']);
        Permission::create(['name' => 'See Pending Posts', 'for' => 'posts']);
        Permission::create(['name' => 'Edit Posts', 'for' => 'posts']);
        Permission::create(['name' => 'Delete Posts', 'for' => 'posts']);
    }
}