<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderRefund extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Order $order): RedirectResponse
    {
        // Members only can refund orders.
        $stripeSecret = config('services.stripe.secret');
        $stripe = new \Stripe\StripeClient($stripeSecret);

        $query = $order
            ->whereNotNull('payment_intent_id')
            ->where('payment_status', 'paid')
            ->where('fulfillment_status', 'fulfilled')
            ->first();

        if (! $query) {
            return back()->with('error', 'The order is not eligible for refund!');
        }

        $stripe->refunds->create([
            'payment_intent' => $query->payment_intent_id,
            'amount' => $query->cart->total,
        ]);

        Log::info('Refunded order: '.$query->id);

        // $query->update([
        //     'payment_status' => 'refunded',
        // ]);
    }
}
