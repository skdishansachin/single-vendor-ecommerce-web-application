<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductDetailsPageTest extends TestCase
{
    use RefreshDatabase;

    protected Product $product;

    public function setUp(): void
    {
        parent::setUp();
        $this->product = Product::factory()->create();
    }

    public function test_product_details_screen_can_be_rendered(): void
    {
        // This request made by unauthenticated user
        $response = $this->get("/products/{$this->product->slug}");

        $response->assertOk();
    }

    public function test_correct_view_is_being_used(): void
    {
        // This request made by unauthenticated user
        $response = $this->get("/products/{$this->product->slug}");

        $response->assertViewIs('product');
    }

    public function test_products_are_being_displayed(): void
    {
        // This request made by unauthenticated user
        $response = $this->get("/products/{$this->product->slug}");

        $response
            ->assertViewHasAll(['product', 'relatedProducts'])
            ->assertSee($this->product->name);
    }
}
