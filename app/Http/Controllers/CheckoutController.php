<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function handleCheckout(Request $request)
    {
        $user = $request->user();

        $cart = Cart::whereBelongsTo($user)
            ->where('type', 'cart')
            ->with('products')
            ->firstOrFail();

        $stripeSecret = config('services.stripe.secret');
        $stripe = new \Stripe\StripeClient($stripeSecret);

        // Map the products to line items
        $lineItems = $cart->products->map(function (Product $product) {
            return [
                'price_data' => [
                    'currency' => 'lkr',
                    'product_data' => [
                        'name' => $product->name,
                        'images' => [$product->getFirstMediaUrl('products')],
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $product->pivot->quantity,
            ];
        })->toArray(); // Convert the collection to an array

        $ShipingOptions = array_values(Shipping::where('is_active', true)
            ->get()
            ->filter(function ($shipping) use ($cart) {
                return $shipping->isApplicable($cart);
            })
            ->map(function (Shipping $shipping) {
                return [
                    'shipping_rate_data' => [
                        'type' => 'fixed_amount',
                        'fixed_amount' => [
                            'amount' => $shipping->cost * 100,
                            'currency' => 'lkr',
                        ],
                        'display_name' => $shipping->name,
                        'delivery_estimate' => [
                            'minimum' => [
                                'unit' => 'business_day',
                                'value' => $shipping->min_delivery_estimate,
                            ],
                            'maximum' => [
                                'unit' => 'business_day',
                                'value' => $shipping->max_delivery_estimate,
                            ],
                        ],
                    ],
                ];
            })->toArray());

        $checkout_session = $stripe->checkout->sessions->create([
            'shipping_address_collection' => ['allowed_countries' => ['LK']],
            'shipping_options' => $ShipingOptions,
            'customer_email' => $user->email,
            'line_items' => $lineItems,
            'mode' => 'payment',
            'invoice_creation' => ['enabled' => true],
            'success_url' => route('checkout.success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel').'?session_id={CHECKOUT_SESSION_ID}',
        ]);

        // Create an order from the cart
        Order::create([
            'user_id' => $user->id,
            'cart_id' => $cart->id,
            'payment_session_id' => $checkout_session->id,
            'payment_session_url' => $checkout_session->url,
        ]);

        return redirect($checkout_session->url);
    }

    public function success(Request $request): View
    {
        if (! $request->filled('session_id')) {
            Log::error('Stripe session ID is missing.');

            return view('checkout.error');
        }

        $order = Order::where('payment_session_id', $request->session_id)->firstOrFail();

        if ($order->payment_status !== 'paid') {
            Log::info('Payment status is not Paid');

            return view('checkout.error');
        }

        $order->load('cart');

        return view('checkout.success', [
            'order' => $order,
        ]);
    }

    public function cancel(Request $request): View
    {
        if (! $request->filled('session_id')) {
            Log::error('Stripe session ID is missing.');

            return view('checkout.error');
        }

        $order = Order::where('payment_session_id', $request->session_id)->firstOrFail();
        $checkout_url = $order->payment_session_url;

        return view('checkout.cancel', [
            'checkout_url' => $checkout_url,
        ]);
    }

    public function error(Request $request): View
    {
        // !is_null($order->payment_session_url) && !$order->created_at->addHours(24)->isPast()
        return view('checkout.error');
    }
}
