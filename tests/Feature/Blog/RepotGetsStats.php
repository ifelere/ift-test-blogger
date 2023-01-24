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

    $stats = $repo->getStats();

    assertTrue(!is_array($stats), 'Stat must be an object');

    assertTrue($stats->number_of_blogs > 0, 'Number of blogs must exceed one');
});
