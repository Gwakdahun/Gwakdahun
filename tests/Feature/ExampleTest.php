<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $validated = '1234';
        dd($password = Hash::make('1234'));

        dd(Hash::check($validated, '$2y$04$9BU3/uYEN1lTsHIW8lpi9e1L4xhlfTU3WeNv2KSRMlwcSxdgC9x/a'));
    }
}
