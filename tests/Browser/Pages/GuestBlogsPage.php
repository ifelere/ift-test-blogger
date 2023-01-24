<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class GuestBlogsPage extends Page
{
    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        return '/blogs';
    }

    /**
     * Assert that the browser is on the page.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url());
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
            '@sidebar_blogs' => 'div > ul.sidebar-blog-list',
            '@central_blogs_anchor' => 'div > div.blogs-central-list a',
            '@sidebar_blogs_anchor' => 'div > ul.sidebar-blog-list a',
        ];
    }

    public function openBlog(Browser $browser, $blog) {
        return $browser->assertSeeIn('@central_blogs_anchor', $blog->title)
        ->with('@central_blogs', function ($el) use ($blog) {
            $el->clickLink($blog->title);
        })->on(new BlogDetailPage($blog));
    }
}
