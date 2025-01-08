<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CollectionController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Collection::class);

        $query = Collection::query()
            ->select('id', 'name', 'slug', 'created_at')
            ->with('products')
            ->latest();

        $collections = $query->paginate(10);

        return view('dashboard.collections.index', [
            'collections' => $collections,
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', Collection::class);

        return view('dashboard.collections.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Collection::class);

        $request->validate([
            'name' => ['required', 'string', 'unique:collections'],
            'description' => ['nullable', 'string'],
            'media' => ['required', 'file', 'mimes:jpeg,png,jpg,webp'],
        ]);

        $collection = Collection::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($request->hasFile('media')) {
            $collection->addMediaFromRequest('media')->toMediaCollection('collections');
        }

        return to_route('dashboard.collections.index');
    }

    public function edit(Collection $collection): View
    {
        Gate::authorize('update', Collection::class);

        $collection->with('products');

        return view('dashboard.collections.edit', [
            'collection' => $collection,
        ]);
    }

    public function update(Request $request, Collection $collection)
    {
        Gate::authorize('update', Collection::class);

        $request->validate([
            'name' => ['required', 'string', "unique:collections,name,$collection->id"],
            'description' => ['required', 'string'],
            'media' => ['nullable', 'file', 'mimes:jpeg,png,jpg,webp'],
        ]);

        $collection->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($request->hasFile('media')) {
            $collection->clearMediaCollection('collections');

            $collection->addMediaFromRequest('media')->toMediaCollection('collections');
        }

        return to_route('dashboard.collections.edit', $collection);
    }

    public function destroy(Collection $collection): RedirectResponse
    {
        Gate::authorize('delete', Collection::class);

        $collection->clearMediaCollection('collections');
        $collection->delete();

        return to_route('dashboard.collections.index');
    }
}
