<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\GuestBlogsPage;
use Tests\DuskTestCase;
use App\Models\User;
use Tests\Browser\Pages\AdminBlogsPage;
use Tests\Browser\Pages\NewBlogPage;
use App\Models\Blog;

class BlogsPageTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testCanVisitGuestBlogsPage(): void
    {
        $this->browse(function (Browser $browser) {
            $blog = Blog::first();
            $browser->visit(new GuestBlogsPage())
                    ->openBlog($blog);
        });
    }

    public function testCanVisitAdminBlogsPage(): void {
        $this->browse(function (Browser $browser) {
            $user = User::whereHas('blogs')->first();
            $browser->loginAs($user);
            $blog = $user->blogs()->first();
            $browser->visit(new AdminBlogsPage())
                    ->openBlog($blog);
        });
    }

    public function testCanVisitNewBlogPageWithValidationError(): void {
        $this->browse(function (Browser $browser) {
            $user = User::whereHas('blogs')->first();
            $browser->loginAs($user);
            $browser->visit(new NewBlogPage())
                    ->submitWithValidationErrors();
        });
    }


    public function testCanVisitNewBlogPageWithNoValidationError(): void {
        $this->browse(function (Browser $browser) {
            $user = User::whereHas('blogs')->first();
            $browser->loginAs($user);
            $browser->visit(new NewBlogPage())
                    ->submitSuccessfully();
        });
    }
}
