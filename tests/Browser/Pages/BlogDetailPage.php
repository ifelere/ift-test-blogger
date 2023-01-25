<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;

class BlogDetailPage extends Page
{
    private $blog;
    public function __construct($blog)
    {
        $this->blog = $blog;
    }
    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        return "/blogs/{$this->blog->id}";
    }

    /**
     * Assert that the browser is on the page.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url())
                ->assertTitleContains($this->blog->title)
                ->assertSeeIn('div h4', $this->blog->title);
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [];
    }
}
