<?php

use App\Models\Blog;
use App\Models\User;

use function PHPUnit\Framework\assertTrue;

test('created blog must have a slug', function () {
    $user = User::factory()->create();

    $blog = $user->blogs()->save(Blog::factory()->withoutSlug()->make());

    assertTrue(!empty($blog->slug));
});
