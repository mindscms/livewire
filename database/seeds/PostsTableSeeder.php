<?php

use App\Category;
use App\Post;
use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $faker = Factory::create();

       for ($i =1; $i <= 15; $i++) {
           Post::create([
               'user_id'        => User::inRandomOrder()->first()->id,
               'category_id'    => Category::inRandomOrder()->first()->id,
               'title'          => $faker->sentence(4),
               'body'           => $faker->paragraph(),
               'image'          => sprintf("%02d", $i).'.jpg',
           ]);
       }


    }
}
