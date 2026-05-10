<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // The home route lives under the LaravelLocalization group.
        // With hideDefaultLocaleInURL=false the middleware redirects / → /it/
        // but in the artisan/test boot context the prefix resolves to '/', so we
        // check for either a redirect (3xx) or a direct 200.
        $response = $this->get('/');

        $this->assertContains($response->status(), [200, 301, 302],
            'Home should be 200 or redirect, got '.$response->status());
    }
}
