<?php

use Illuminate\Database\Seeder;
use App\PostCategory;

class PostCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PostCategory::create([
            'name'        => 'Uncategorized',
            'description' => 'A default post category'
        ]);
    }
}
