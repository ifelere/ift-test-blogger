<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class AdminBlogsPage extends Page
{
    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        return '/admin/blogs';
    }

    /**
     * Assert that the browser is on the page.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url())
            ->seeLink('Add');
    }

    public function openBlog(Browser $browser, $blog) {
        return $browser->assertPresent(sprintf('a[data-id="%s"]', $blog->id))
                ->click(sprintf('a[data-id="%s"]', $blog->id))
                ->on(new AdminBlogDetailPage($blog));
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [
            '@container' => 'div > div.blogs-central-list',
            '@link' => 'div > div.blogs-central-list a',
        ];
    }
}
