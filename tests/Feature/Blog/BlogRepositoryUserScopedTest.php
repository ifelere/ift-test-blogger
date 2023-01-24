<?php

use Illuminate\Support\Facades\Artisan;

use App\Repositories\BlogRepository;

use function PHPUnit\Framework\assertTrue;

use App\Models\User;

beforeEach(function () {
    $this->seed();
});

test('as guest repository returns blogs from any user', function () {
    $repo = app(BlogRepository::class);

    $user_ids = $repo->findAll(false)->selectRaw('distinct publisher_id')->get();

    assertTrue($user_ids->count() > 1, 'Number of publsher ids must be more than one');
});


test('blogs returned must belong to only one publisher', function () {
    $user = User::whereHas('blogs')->first();
    
    $this->actingAs($user);

    $repo = app(BlogRepository::class);

    $user_ids = $repo->findAll(false)->selectRaw('distinct publisher_id')->get();

    assertTrue($user_ids->count() == 1, 'Number of publsher ids must be exactly one');

    assertTrue($user_ids->first()->publisher_id === $user->id, 'Must be same publisher as current user');

});