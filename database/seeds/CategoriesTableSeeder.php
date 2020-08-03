<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Web Development'
        ]);
        Category::create([
            'name' => 'Web Design'
        ]);
        Category::create([
            'name' => 'Mobile Development'
        ]);
    }
}
