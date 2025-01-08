<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_screen_can_be_rendered(): void
    {
        // This request made by unauthenticated user
        $response = $this->get('/');

        $response->assertOk();
    }

    public function test_correct_view_is_being_used(): void
    {
        // This request made by unauthenticated user
        $response = $this->get('/');

        $response->assertViewIs('index');
    }

    public function test_products_are_being_displayed(): void
    {
        $products = Product::factory()->create();

        // This request made by unauthenticated user
        $response = $this->get('/');

        $response
            ->assertViewHas('products')
            ->assertSee($products->name);
    }
}
