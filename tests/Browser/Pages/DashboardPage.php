<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class DashboardPage extends Page
{
    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        return '/dashboard';
    }

    /**
     * Assert that the browser is on the page.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url())
                    ->assertVisible('@add_link')
                    ->assertVisible('@central_blogs')
                    ->assertVisible('@sidebar_blogs');
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [
            '@add_link' => 'a.add-blog',
            '@central_blogs' => 'div > div.blogs-central-list',
            '@sidebar_blogs' => 'div > .sidebar-blog-list',
            '@central_blogs_anchor' => 'div > div.blogs-central-list a',
            '@sidebar_blogs_anchor' => 'div > .sidebar-blog-list a',
        ];
    }
}
