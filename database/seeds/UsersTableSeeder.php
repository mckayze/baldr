<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superuser = User::create([
            'username' => 'badboykenzie',
            'name' => 'McKenzie Flavius',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password')
        ]);
        $superuser->assignRole('Super Administrator');

        $testuser = User::create([
            'username' => 'tessbess',
            'name' => 'Test User',
            'email' => 'test@user.com',
            'password' => bcrypt('password')
        ]);
        $testuser->assignRole('Administrator');
    }
}