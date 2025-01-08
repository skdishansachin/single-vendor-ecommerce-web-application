<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomePageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $products = Product::with('collection')->inRandomOrder()->take(4)->get();

        $collections = Cache::remember('collections', 60, function () {
            return Collection::with('products')->take(5)->get();
        });

        return view('index', [
            'products' => $products,
            'collections' => $collections,
        ]);
    }
}
