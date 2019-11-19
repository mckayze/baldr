<?php

use Illuminate\Database\Seeder;
use App\Theme;

class ThemeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Theme::create([
            'name' => 'default',
            'path' => 'frontend/default_theme/',
            'active' => true
        ]);
    }
}