<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class UserOrderController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $orders = $user->orders()->whereHas('cart', function ($query) {
            $query->where('type', 'order');
        })->with('cart.products.collection')->get();

        return view('profile.orders', [
            'orders' => $orders,
        ]);
    }
}
