<x-app-layout title="Orders">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <div class="sm:hidden">
                    <form action="{{ route('dashboard.orders.index') }}" method="get" onclick="this.closest('form').submit();">
                        <label for="tab" class="sr-only">Select a tab</label>
                        <select id="tab" name="tab" class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="all" selected>All</option>
                            <option value="unfulfilled">Unfulfilled</option>
                            <option value="unpaid">Unpaid</option>
                            <option value="fulfilled">Fulfilled</option>
                            <option value="archived">Archived</option>
                        </select>
                    </form>
                </div>
                <div class="hidden sm:block">
                    <nav class="flex space-x-4" aria-label="Tabs">
                        <a href="{{ route('dashboard.orders.index', ['tab' => 'all']) }}" class="{{ $tab === 'all' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700' }} rounded-md px-3 py-2 text-sm font-medium">
                            All
                        </a>
                        <a href="{{ route('dashboard.orders.index', ['tab' => 'unfulfilled']) }}" class="{{ $tab === 'unfulfilled' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700' }} rounded-md px-3 py-2 text-sm font-medium">
                            Unfulfilled
                        </a>
                        <a href="{{ route('dashboard.orders.index', ['tab' => 'unpaid']) }}" class="{{ $tab === 'unpaid' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700' }} rounded-md px-3 py-2 text-sm font-medium">
                            Unpaid
                        </a>
                        <a href="{{ route('dashboard.orders.index', ['tab' => 'fulfilled']) }}" class="{{ $tab === 'fulfilled' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700' }} rounded-md px-3 py-2 text-sm font-medium">
                            Fulfilled
                        </a>
                        <a href="{{ route('dashboard.orders.index', ['tab' => 'archived']) }}" class="{{ '' === 'archived' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700' }} rounded-md px-3 py-2 text-sm font-medium">
                            Archived
                        </a>
                    </nav>
                </div>
            </div>

            <div class="flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-white">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-xs font-medium uppercase text-gray-500 sm:pl-6">Order</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase text-gray-500">Date</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase text-gray-500">Customer</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase text-gray-500">Total</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase text-gray-500">Payment Status</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase text-gray-500">Fulfillment Status</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase text-gray-500">Items</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">show</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($orders as $order)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 uppercase">#{{ Str::take($order->id, 5) }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $order->created_at->toDayDateTimeString() }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $order->user->name }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $order->formattedPrice }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <span class="{{ $order->payment_status == 'paid' ? 'badge-success' : 'badge-warning' }}">{{ $order->payment_status }}</span>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <span class="{{ $order->fulfillment_status == 'fulfilled' ? 'badge-success' : 'badge-warning' }}">{{ $order->fulfillment_status }}</span>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $order->cart->products()->sum('quantity') }}</td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <a href="{{ route('dashboard.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900">View<span class="sr-only">, {{ $order->id }}</span></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($orders->hasPages())
                            <div class="p-4">{{ $orders->appends(request()->input())->links('pagination::tailwind') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>