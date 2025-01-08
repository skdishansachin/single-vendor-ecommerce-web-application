<?php

use App\Models\Collection;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_product_list_screen_can_be_rendered(): void
    {
        $response = $this->get(route('dashboard.products.index'));
        $response->assertOk();
    }

    public function test_product_create_screen_can_be_rendered(): void
    {
        $response = $this->get(route('dashboard.products.create'));
        $response
            ->assertOk()
            ->viewData('collections');
    }

    public function test_product_can_be_created(): void
    {
        // TODO - Refactor the test to user roles and permissions

        $collection = Collection::factory()->create();
        $product = Product::factory()->make()->toArray();

        $product['media'] = [
            UploadedFile::fake()->image('product_image_1.jpg'),
            UploadedFile::fake()->image('product_image_2.jpg'),
            UploadedFile::fake()->image('product_image_3.jpg'),
        ];

        $product['collection'] = $collection->id;

        $response = $this->post(route('dashboard.products.store'), $product);

        $response->assertSessionHasNoErrors();
        $response->assertRedirectToRoute('dashboard.products.index');
        $this->assertDatabaseHas(Product::class, [
            'name' => $product['name'],
        ]);
        $this->assertDatabaseCount(Product::class, 1); // Only one product created.
    }

    public function test_product_edit_screen_can_be_rendered(): void
    {
        $product = Product::factory()->create();

        $response = $this->get(route('dashboard.products.edit', $product));

        $response->assertOk();
    }

    public function test_product_can_be_updated(): void
    {
        $product = Product::factory()->create();
        $newProduct = product::factory()->make();

        $response = $this->put(route('dashboard.products.update', $product), $newProduct->toArray());

        $response->assertSessionHasNoErrors();
        $response->assertRedirectToRoute('dashboard.products.edit', $product);

        $this->assertDatabaseHas(Product::class, [
            'name' => $newProduct->name,
        ]);
    }

    // TODO - Add test for product deletion
}
