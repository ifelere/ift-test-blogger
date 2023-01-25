<?php

use Illuminate\Support\Facades\Artisan;

use function PHPUnit\Framework\assertTrue;

test('call import via console', function () {
    $result = Artisan::call('posts:import');
    assertTrue($result == 0);
});
