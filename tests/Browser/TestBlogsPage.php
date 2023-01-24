<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\GuestBlogsPage;
use Tests\DuskTestCase;
use App\Models\User;
use Tests\Browser\Pages\AdminBlogsPage;
use Tests\Browser\Pages\NewBlogPage;

class TestBlogsPage extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testCanVisitGuestBlogsPage(): void
    {
        $this->browse(function (Browser $browser) {
            $blog = Blog::first();
            $browser->visit(new GuestBlogsPage())
                    ->openBog($blog);
        });
    }

    public function testCanVisitAdminBlogsPage(): void {
        $this->browse(function (Browser $browser) {
            $user = User::whereHas('blogs')->first();
            $this->loginAs($user);
            $blog = $user->blogs()->first();
            $brower->visit(new AdminBlogsPage())
                    ->openBog($blog);
        });
    }

    public function testCanVisitNewBlogPageWithValidationError(): void {
        $this->browse(function (Browser $browser) {
            $user = User::whereHas('blogs')->first();
            $this->loginAs($user);
            $brower->visit(new NewBlogPage())
                    ->submitWithValidationErrors();
        });
    }


    public function testCanVisitNewBlogPageWithNoValidationError(): void {
        $this->browse(function (Browser $browser) {
            $user = User::whereHas('blogs')->first();
            $originalCount = Blog::count();
            $this->loginAs($user);
            $brower->visit(new NewBlogPage())
                    ->submitSuccessfully();
        });
    }
}
