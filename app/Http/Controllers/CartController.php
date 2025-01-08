<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $cart = $user->cart()->where('type', 'cart')->firstOrCreate([
            'user_id' => $user->id,
            'type' => 'cart',
        ]);
        $cart->load('products.collection');

        // Calculate subtotal and total
        $cart->subtotal = $cart->products->sum(function (Product $product) {
            return $product->price * $product->pivot->quantity;
        });

        $relatedProducts = Product::with('collection')->whereNotIn('id', $cart->products->pluck('id'))->inRandomOrder()->take(4)->get();

        return view('cart', [
            'cart' => $cart,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product' => ['required', 'exists:products,id'],
        ]);

        $user = $request->user();
        $product = Product::findOrFail($request->product);
        $quantity = 1;

        if ($quantity > $product->available) {
            return redirect()->route('cart')->with('message', "You can't add more $product->name to the cart than available.");
        }

        $cart = $user->cart()->where('type', 'cart')->firstOrCreate([
            'user_id' => $user->id,
            'type' => 'cart',
        ]);

        DB::transaction(function () use ($cart, $product, $quantity) {
            $subtotal = $quantity * $product->price;

            // Sync the product with the cart, without detaching any existing associations.
            $cart->products()->syncWithoutDetaching([
                $product->id => [
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ],
            ]);

            $cart->subtotal = $cart->products->sum(function ($product) {
                return $product->price * $product->pivot->quantity;
            });

            $cart->save();
        });

        return redirect()->route('cart')->with('success', 'Product added to cart.');
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $quantity = $request->quantity;

        $user = $request->user();
        $product = Product::findOrFail($request->product_id);
        $cart = $user->cart()->where('type', 'cart')->firstOrFail();

        if ($quantity > $product->available) {
            // return redirect()->route('cart')->with('message', "You can't add more $product->name to the cart than available.");
            session()->flash('message', "You can't add more $product->name to the cart than available.");

            return response()->json(['message' => 'success']);
        }

        DB::transaction(function () use ($cart, $product, $quantity) {
            $subtotal = $quantity * $product->price;

            // Sync the product with the cart, without detaching any existing associations.
            $cart->products()->syncWithoutDetaching([
                $product->id => [
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ],
            ]);

            $cart->subtotal = $cart->products->sum(function ($product) {
                return $product->price * $product->pivot->quantity;
            });

            $cart->save();
        });

        return response()->json(['message' => 'success']);
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $user = $request->user();
        $product = Product::findOrFail($request->product_id);

        $cart = $user->cart()->where('type', 'cart')->firstOrFail();

        // Detach the product from the cart
        $cart->products()->detach($product->id);

        // If cart is empty, delete it
        if ($cart->products()->count() === 0) {
            $cart->delete();

            // return redirect()->route('cart')->with('success', 'Cart is now empty.');
            return response()->json(['message' => 'success']);
        }

        // Update cart totals
        $cart->subtotal = $cart->products->sum(function ($product) {
            return $product->price * $product->pivot->quantity;
        });

        $cart->save();

        return response()->json(['message' => 'success']);
    }
}
