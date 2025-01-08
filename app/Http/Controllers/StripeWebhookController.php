<?php

namespace App\Http\Controllers;

use App\Events\OrderSuccessful;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $stripeSecret = config('services.stripe.secret');
        $stripeWebhookSecret = config('services.stripe.webhook_secret');
        $stripe = new \Stripe\StripeClient($stripeSecret);

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $stripeWebhookSecret
            );
        } catch (\UnexpectedValueException $e) {
            Log::error("Stripe Webhook error: Invalid payload $e");

            return response('', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error("Stripe Webhook error: Invalid signature $e");

            return response('', 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;

                Log::info($session);
                dump($session);

                Log::info("The session URL - $session->url");

                DB::transaction(function () use ($session) {
                    $order = Order::where('payment_session_id', $session->id)
                        ->where('status', 'pending') // Updated status
                        ->firstOrFail();

                    // Decrement the product quantities
                    $cart = Cart::findOrFail($order->cart_id);

                    $cart->products->each(function (Product $product) {
                        $quantityOrdered = $product->pivot->quantity;
                        $product->decrement('available', $quantityOrdered);

                        $product->pivot->purchase_price = $product->price;
                        $product->pivot->save();
                    });

                    $cart->update([
                        'type' => 'order',
                        'total' => $session->amount_total / 100,
                        'subtotal' => $session->amount_subtotal / 100,
                    ]);

                    $order->update([
                        'status' => 'completed',
                        'payment_status' => 'paid',
                        'payment_intent_id' => $session->payment_intent,
                        'shipping_price' => ($session->shipping_cost->amount_subtotal ?? 0) / 100,
                        'city' => $session->shipping_details->address->city,
                        'country' => $session->shipping_details->address->country,
                        'line1' => $session->shipping_details->address->line1,
                        'line2' => $session->shipping_details->address->line2,
                        'postal_code' => $session->shipping_details->address->postal_code,
                        'state' => $session->shipping_details->address->state,
                    ]);

                    OrderSuccessful::dispatch($order);
                });

                break;

            case 'payment_intent.payment_failed':
                $session = $event->data->object;

                Log::info('Checkout page -'.$session->url);

                Log::info('Payment failed - '.$session->id);

                $order = Order::where('payment_session_id', $session->id)
                    ->where('status', 'pending') // Updated status
                    ->firstOrFail();

                $order->update([
                    'payment_status' => 'unpaid',
                ]);

                break;

            default:
                Log::info('Received unknown event type '.$event->type);
        }

        return response('');
    }
}
