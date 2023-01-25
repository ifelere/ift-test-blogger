<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Carbon;

use Illuminate\Support\Arr;

use Illuminate\Support\Str;

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
        $title = Str::ucfirst(fake()->words(6, true));
        return [
            'title' => $title,
            'description' => fake()->paragraph(3, true),
            'published_at' => Carbon::now()->subDays(random_int(2, 4)),
            'publisher_id' => 0,
            'slug' => Str::slug($title)
        ];
    }

    public function publishedBy() {
       return $this->state(function ($attributes) {
        $title = Str::ucfirst(fake()->words(6, true));
            return [
                'title' => $title,
                'slug' => Str::slug($title),
                'description' => fake()->paragraph(10, true),
                'published_at' => Arr::get($attributes, 'published_at', Carbon::now()->subDays(random_int(2, 4))),
                'publisher_id' => Arr::get($attributes, 'user_id', Arr::get($attributes, 'publisher_id')),
            ];
       });
    }

    public function withoutSlug() {
        return $this->state(function ($attributes) {
            $title = Str::ucfirst(fake()->words(6, true));
            return [
                'title' => $title,
                'description' => fake()->paragraph(10, true),
                'published_at' => Arr::get($attributes, 'published_at', Carbon::now()->subDays(random_int(2, 4))),
                'publisher_id' => Arr::get($attributes, 'user_id', Arr::get($attributes, 'publisher_id')),
            ];
        });
    }
}
