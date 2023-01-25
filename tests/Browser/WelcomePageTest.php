<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\WelcomePage;
use Tests\DuskTestCase;
use App\Models\Blog;

class WelcomePageTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testVisitWelcomePageShowsBlogs(): void
    {
        $sampleBlog = Blog::first();

        $this->browse(function (Browser $browser) {
            $browser->visit(new WelcomePage());
        });
    }
}
