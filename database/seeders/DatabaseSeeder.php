<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Blog;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(20)->hasBlogs(
            Blog::factory()->count(random_int(10, 20))
            ->state(function (array $attributes, User $user) {
                return ['publisher_id', $user->id];
            }))
            ->create();


      // Seed users without blogs       
      User::factory(5)
        ->create();
    }
}
