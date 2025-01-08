<?php

namespace App\Http\Controllers;

use App\Events\OrderFulfilled;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Order::class);

        $query = Order::query()
            ->with(['user', 'cart.products'])
            ->orderByDesc('created_at');

        $tab = $request->query('tab', 'all');

        $query
            ->when(Str::is('all', $tab), function (Builder $query) {
                return $query->where('payment_status', 'paid');
            })
            ->when(Str::is('unfulfilled', $tab), function (Builder $query) {
                return $query->where('fulfillment_status', 'unfulfilled');
            })
            ->when(Str::is('fulfilled', $tab), function (Builder $query) {
                return $query->where('fulfillment_status', 'fulfilled');
            })
            ->when(Str::is('unpaid', $tab), function (Builder $query) {
                return $query->where('payment_status', 'unpaid');
            });

        $query = $query->paginate(10);

        return view('dashboard.orders.index', [
            'orders' => $query,
            'tab' => $tab,
        ]);
    }

    public function show(Order $order): View
    {
        Gate::authorize('view', Order::class);

        $order->load('user', 'cart', 'cart.products');

        return view('dashboard.orders.show', [
            'order' => $order,
        ]);
    }

    public function update(Request $request, Order $order): JsonResponse
    {
        Gate::authorize('update', Order::class);

        $request->validate([
            'status' => [Rule::in(['pending', 'completed', 'cancelled', 'returned'])],
            'fulfillment_status' => [Rule::in(['unfulfilled', 'fulfilled'])],
            'payment_status' => [Rule::in(['unpaid', 'paid', 'refunded', 'cancelled'])],
        ]);

        $order->update([
            'fulfillment_status' => $request->fulfillment_status,
        ]);

        if ($request->has('fulfillment_status') && $request->fulfillment_status === 'fulfilled') {
            OrderFulfilled::dispatch($order);
        }

        session()->flash('message', 'Order upadted successfuly');

        return response()->json([
            'message' => 'success',
        ]);
    }
}
