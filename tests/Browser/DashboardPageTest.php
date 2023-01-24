<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\DashboardPage;
use Tests\DuskTestCase;
use App\Models\User;

class DashboardPageTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testVisitDashboardShowsOnlyBlogsWithoutAuthorText(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::whereHas('blogs')->first();
            $browser->loginAs($user);
            $browser->visit(new DashboardPage())
                        ->assertDontSee('Author');
        });
    }
}
