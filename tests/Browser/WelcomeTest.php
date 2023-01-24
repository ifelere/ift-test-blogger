<?php

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\WelcomePage;

test('Welcome page has blogs', function () {
   $this->browse(function (Browser $browser) {
        $browser->visit(new WelcomePage());
   });
});
