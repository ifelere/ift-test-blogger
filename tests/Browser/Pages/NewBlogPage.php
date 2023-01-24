<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page;
use Illuminate\Foundation\Testing\WithFaker;

class NewBlogPage extends Page
{
    use WithFaker;

    public function __construct()
    {
        $this->setUpFaker();
    }

    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        return '/admin/blogs/create';
    }

    /**
     * Assert that the browser is on the page.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertPathIs($this->url());
    }

    public function submitWithValidationErrors(Browser $browser) {
        
        return $browser->value('title', $this->faker->words(2, true))
                        ->click('@submit_button')
                        ->on(new NewBlogPage())
                        ->assertPresent('.error');
    }

    public function submitSuccessfully(Browser $browser) {
        
        return $browser->value('title', $this->faker->words(2, true))
                        ->value('description', $this->faker->paragraphs(4, true))
                        ->click('@submit_button')
                        ->on(new AdminBlogsPage());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array<string, string>
     */
    public function elements(): array
    {
        return [
            '@submit_button' => 'div form button[type="submit"]',
        ];
    }
}
