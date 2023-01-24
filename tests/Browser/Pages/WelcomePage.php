<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class WelcomePage extends Page
{
    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        return '/';
    }

    /**
     * Assert that the browser is on the page.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url())
        ->assertSee('@central_blogs')
        ->assertSee('@sidebar_blogs');
    
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [
            '@central_blogs' => 'div > div.blogs-central-list',
            '@sidebar_blogs' => 'div > ul.sidebar-blog-list'
        ];
    }
}
