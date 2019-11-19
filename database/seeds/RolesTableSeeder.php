<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Super Administrator']);
        Role::create(['name' => 'Custom']);

        /**
         * Administrator
         */
        Role::create(['name' => 'Administrator'])->givePermissionTo([
            'View Dashboard Page',
            'View Dashboard Metrics'
        ]);

        /**
         *
         */
        Role::create(['name' => 'Author']);
        Role::create(['name' => 'Contributor']);
    }
}
