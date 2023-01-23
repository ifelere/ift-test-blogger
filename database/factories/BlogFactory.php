<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Carbon;

use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    protected $model = Blog::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->words(3, true),
            'descripption' => fake()->sentences(10, true),
            'published_at' => Carbon::now()->subDays(random_int(2, 4)),
            'publisher_id' => 0
        ];
    }

    public function publishedBy() {
       return $this->state(function ($attributes) {
            return [
                'title' => fake()->words(3, true),
                'descripption' => fake()->sentences(10, true),
                'published_at' => Arr::get($attributes, 'published_at', Carbon::now()->subDays(random_int(2, 4))),
                'publisher_id' => Arr::get($attributes, 'user_id', Arr::get($attributes, 'publisher_id')),
            ];
       });
    }
}
