<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\View\View;

class CollectionPageController extends Controller
{
    public function index(): View
    {
        // TODO: Paginate the collections
        $collections = Collection::get(['id', 'name', 'slug'])->all();

        return view('collections.index', compact('collections'));
    }

    public function show(Collection $collection): View
    {
        $products = $collection->with('products');

        return view('collections.show', compact('collection'));
    }
}
