<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $query = $request->input('query');
        $collections = Collection::take(4)->get();
        $results = null;

        if (! empty($query)) {
            $results = Product::where('name', 'like', "%$query%")
                ->orWhere('description', 'like', "%$query%")
                ->get();
        }

        return view('search', compact('collections', 'results', 'query'));
    }
}
