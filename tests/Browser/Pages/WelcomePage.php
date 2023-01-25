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
        ->assertVisible('@central_blogs')
        ->assertVisible('@sidebar_blogs')
        ->assertVisible('@central_blogs_anchor')
        ->assertVisible('@sidebar_blogs_anchor');
        
    
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
            '@sidebar_blogs' => 'div > .sidebar-blog-list',
            '@central_blogs_anchor' => 'div > div.blogs-central-list a',
            '@sidebar_blogs_anchor' => 'div > .sidebar-blog-list a',
        ];
    }
}
