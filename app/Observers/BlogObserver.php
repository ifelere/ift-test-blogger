<?php

namespace App\Observers;

use App\Models\Blog;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
class BlogObserver
{

    const MAX_SLUG_ATTEMPT = 10;

    /**
     * Ensures that blog has a slug
     */
    public function creating(Blog $blog) {
        if (empty($blog->slug)) {
            $blog->slug = static::generateSlug($blog->title);
        }
    }


    /**
     * Handle the Blog "created" event.
     *
     * @param  \App\Models\Blog  $blog
     * @return void
     */
    public function created(Blog $blog)
    {
        //
    }

    /**
     * Handle the Blog "updated" event.
     *
     * @param  \App\Models\Blog  $blog
     * @return void
     */
    public function updated(Blog $blog)
    {
        //
    }

    /**
     * Handle the Blog "deleted" event.
     *
     * @param  \App\Models\Blog  $blog
     * @return void
     */
    public function deleted(Blog $blog)
    {
        //
    }

    /**
     * Handle the Blog "restored" event.
     *
     * @param  \App\Models\Blog  $blog
     * @return void
     */
    public function restored(Blog $blog)
    {
        //
    }

    /**
     * Handle the Blog "force deleted" event.
     *
     * @param  \App\Models\Blog  $blog
     * @return void
     */
    public function forceDeleted(Blog $blog)
    {
        //
    }


    /**
     * Generate an ensure that slug is unique
     * @param $title title of a blog 
     * @return Generated slug
     */
    private static function generateSlug($title): string {
        $slug = Str::slug($title);
        return static::ensureUniqueSluge($slug, 0, 1);
    }

    /**
     * Recusive  method to generate slugs with a numberic suffix to make it unique. If no matching slug is found then the original slug is returned
     */
    private static function ensureUniqueSluge($slug, $suffix_index, $attempt = 0): string {
        if ($attempt > self::MAX_SLUG_ATTEMPT) {
            throw new Exception('Exhausted attempts to generate a unique slug');
        }

        $size = 10;

        // Geerate a sampling of slugs with numeric suffix
        
        $slugs = array_map(function ($idx) use ($slug) {
            if ($idx == 0) {
                return $slug;
            }
            return sprintf('%s(%s)', $slug, $idx);
        }, range($suffix_index, $size + $suffix_index));

        // Try and look up stored slugs with generated samples
        $existing = Blog::whereIn('slug', $slugs)->select('slug')->get()->map(fn ($blog, $key) => $blog->slug);

        // If no stored slug was found then the slug argument i unique
        if ($existing->isEmpty()) {
            return $slug;
        }

        // Or else look for sample slug that is not part of stored slugs
        $available_slug = Arr::first($slugs, function ($item) use ($existing) {
            return !$existing->contains($item);
        });

        if ($available_slug) {
            return $available_slug;
        }

        // If all samples are found in db generate another batch
        return static::ensureUniqueSluge($slug, $suffix_index + $size + 1, $attempt + 1);
    }
}
