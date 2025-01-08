<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\FileAdder;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Product::class);

        $query = Product::query()
            ->select('id', 'name', 'slug', 'price', 'available', 'collection_id', 'created_at')
            ->with('collection')
            ->latest();

        $products = $query->paginate(10);

        return view('dashboard.products.index', [
            'products' => $products,
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', Product::class);

        $collections = Collection::select('id', 'name')->get();

        return view('dashboard.products.create', [
            'collections' => $collections,
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        Gate::authorize('create', Product::class);

        $request->validated();

        $product = Product::create([
            'collection_id' => $request->collection,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'available' => $request->available,
        ]);

        // Handle media uploads
        if ($request->hasFile('media')) {
            $product->addMultipleMediaFromRequest(['media'])
                ->each(function (FileAdder $fileAdder) {
                    $fileAdder->toMediaCollection('products');
                });
        }

        return to_route('dashboard.products.edit', $product)->with([
            'type' => 'success',
            'message' => 'Product created successfully.',
        ]);
    }

    public function edit(Product $product): View
    {
        Gate::authorize('update', Product::class);

        $collections = Collection::select('id', 'name')->get();

        return view('dashboard.products.edit', [
            'product' => $product,
            'collections' => $collections,
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        Gate::authorize('update', Product::class);

        $request->validated();

        $product->update([
            'collection_id' => $request->collection,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'available' => $request->available,
        ]);

        if ($request->hasFile('media')) {
            $product->clearMediaCollection('products');

            $product->addMultipleMediaFromRequest(['media'])
                ->each(function (FileAdder $fileAdder) {
                    $fileAdder->toMediaCollection('products');
                });
        }

        return to_route('dashboard.products.edit', $product)->with([
            'type' => 'success',
            'message' => 'Product updated successfully.',
        ]);
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->clearMediaCollection('products');
        $product->delete();

        return to_route('dashboard.products.index');
    }
}
