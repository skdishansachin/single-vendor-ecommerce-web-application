<?php

namespace Tests\Feature;

use App\Models\Collection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_collection_list_screen_can_be_rendered(): void
    {
        $response = $this->get(route('dashboard.collections.index'));
        $response->assertOk();
    }

    public function test_collection_create_screen_can_be_rendered(): void
    {
        $response = $this->get(route('dashboard.collections.create'));
        $response->assertOk();
    }

    public function test_collection_can_be_created(): void
    {
        $collection = Collection::factory()->make()->toArray();

        $collection['media'] = UploadedFile::fake()->image('collection.jpg');

        $response = $this->post(route('dashboard.collections.store'), $collection);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirectToRoute('dashboard.collections.index');

        $this->assertDatabaseHas('collections', [
            'name' => $collection['name'],
        ]);
        $this->assertDatabaseCount('collections', 1); // Only one collection created.
    }

    public function test_collection_edit_screen_can_be_rendered(): void
    {
        $collection = Collection::factory()->create();

        $response = $this->get(route('dashboard.collections.edit', $collection));

        $response
            ->assertOk()
            ->assertViewHas('collection', $collection);
    }

    public function test_collection_can_be_updated(): void
    {
        $collection = Collection::factory()->create();

        $collectionData = [
            'name' => 'Updated Collection Name',
            'description' => 'Updated Collection Description',
            'media' => UploadedFile::fake()->image('collection.jpg'),
        ];

        $response = $this->put(route('dashboard.collections.update', $collection), $collectionData);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirectToRoute('dashboard.collections.edit', $collection); // The old collection slug won't update.

        $this->assertDatabaseHas('collections', [
            'name' => $collectionData['name'],
        ]);
    }

    // TODO - Add test for collection deletion
}
