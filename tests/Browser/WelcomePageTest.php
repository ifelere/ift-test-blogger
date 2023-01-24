<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\WelcomePage;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Artisan;

use App\Models\User;

class WelcomePageTest extends DuskTestCase
{
    use  DatabaseMigrations;
    /**
     * A Dusk test example.
     */
    public function testHasBlogsOnWelcomePage(): void
    {
        Artisan::call("db:seed");

        $this->browse(function (Browser $browser) {
            $browser->visit(new WelcomePage())
                    ->assetSee('Author:');

            $user = User::whereHas('blogs')->firstOrFail();

            $this->loginAs($user);

            $browser->visit(new WelcomePage())
            ->assertNotSee('Author:');

        });


    }
}
