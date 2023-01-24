<?php

use App\Models\User;
use App\Repositories\BlogRepository;

use function PHPUnit\Framework\assertTrue;

beforeEach(function () {
    $this->seed();
});

test('gets stats from report', function () {
    $user = User::whereHas('blogs')->first();


    $this->loginAs($user);

    $repo = app(BlogRepository::class);

    $expected_blog_count = $user->blogs()-count();

    $stats = $repo->getStats();

    assertTrue(!is_array($stats), 'Stat must be an object');

    assertTrue($stats->number_of_blogs == $expected_blog_count, 'Number of blogs must same as from direct user relation count');
});
