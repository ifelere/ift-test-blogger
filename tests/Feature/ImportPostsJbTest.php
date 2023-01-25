<?php

use App\Jobs\ImportPostsJob;
use Illuminate\Support\Facades\Artisan;

use function PHPUnit\Framework\assertTrue;

use App\Models\User;

test('call import via console', function () {
    $result = Artisan::call('posts:import');
    assertTrue($result == 0);
});

test("call job directly", function () {
    $user = User::factory()->make();
    $user->is_system = true;
    $user->saveOrFail();

    $job = new ImportPostsJob($user->id);

    $job->handle();

    assertTrue($job->getNumberOfImportedRecords() > 0);
});
