<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductPageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Product $product): View
    {
        $relatedProducts = Product::with('collection')->get()->take(4);

        return view('product', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
