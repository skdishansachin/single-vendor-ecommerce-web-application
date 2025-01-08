<x-app-layout title="Order Details">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order') }}
        </h2>
        <div class="flex items-baseline gap-4">
            @if (! $order->isFulfilled() && $order->isPaid())
            <x-primary-button id="fulfillBtn">fulfill</x-primary-button>
            @endif
            <a href="{{ route('dashboard.orders.index') }}">
                <x-secondary-button>Back</x-secondary-button>
            </a>
            <div class="[--placement:bottom-right] relative inline-block text-left hs-dropdown px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                <div>
                    <button type="button" class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900 hs-dropdown-toggle" id="menu-button" aria-expanded="false" aria-haspopup="true">
                        More Actions
                        <svg class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500 hs-dropdown-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <div class="hs-dropdown-menu hidden absolute left-0 z-10 mt-2 w-40 origin-top-left rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                    <div class="py-1">
                        @if ($order->isPaid())
                        <button type="button" id="refundBtn" class="block px-4 py-2 text-sm font-medium text-gray-900">Refund</button>
                        @endif
                        <button type="button" class="block px-4 py-2 text-sm font-medium text-gray-900">Cancel</button>
                        <button type="button" class="block px-4 py-2 text-sm font-medium text-gray-900">Archive</button>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    <x-alert :message="session('message')" />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div>
                                <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                                    {{ __('Order Details') }}
                                </h2>
                                <div class="mt-4 flex items-center justify-between">
                                    <p class="block text-sm text-gray-700">
                                        Order placed: {{ $order->created_at->toDayDateTimeString() }}
                                    </p>
                                    <div>
                                        <span class="{{ $order->payment_status == 'paid' ? 'badge-success' : 'badge-warning' }}">{{ $order->payment_status }}</span>
                                        <span class="{{ $order->fulfillment_status == 'fulfilled' ? 'badge-success' : 'badge-warning' }}">{{ $order->fulfillment_status }}</span>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="py-2 text-gray-900">
                                        <div class="flex flex-col">
                                            <div class="overflow-x-auto">
                                                <div class="min-w-full inline-block align-middle">
                                                    <div class="overflow-hidden">
                                                        <table class="min-w-full divide-y divide-gray-200">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" class="pe-4 py-3 text-start text-xs font-medium text-gray-500 uppercase">Name</th>
                                                                    <th scope="col" class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase">Qty</th>
                                                                    <th scope="col" class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase">Price</th>
                                                                    <th scope="col" class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase">Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-200">
                                                                @foreach($order->cart->products as $product)
                                                                <tr>
                                                                    <td class="pe-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                                        <div class="flex items-center">
                                                                            <img class="w-12 h-12 max-w-full object-cover rounded-lg mr-5" src="{{ $product->getFirstMedia('products')->getUrl() }}" alt="{{ $product->name }}" loading="lazy" />
                                                                            {{ $product->name }}
                                                                        </div>
                                                                    </td>
                                                                    <td class="p-4 whitespace-nowrap text-sm text-gray-800"><span class="pe-1">x</span>{{ $product->pivot->quantity }}</td>
                                                                    <td class="p-4 whitespace-nowrap text-sm text-gray-800">{{ Number::currency($product->pivot->purchase_price, 'LKR') }}</td>
                                                                    <td class="p-4 whitespace-nowrap text-sm text-gray-800">{{ Number::currency($product->pivot->subtotal, 'LKR') }}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                                    {{ __('Paid by Customer') }}
                                </h2>
                                <div class="mt-4">
                                    <ul class="flex flex-col">
                                        <!-- TODO - Messy border -->
                                        <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm border-t border-x text-gray-800 first:rounded-t-lg first:mt-0 last:rounded-b-lg">
                                            <div class="flex items-center justify-between w-full">
                                                <span>Subtotal</span>
                                                <span>{{ Number::currency($order->cart->subtotal, 'LKR') }}</span>
                                            </div>
                                        </li>
                                        <li class="inline-flex items-center gap-x-2 pb-3 px-4 text-sm border-x text-gray-800 first:rounded-t-lg first:mt-0 last:rounded-b-lg">
                                            <div class="flex items-center justify-between w-full">
                                                <!-- TODO - Shipping fee -->
                                                <span>Shipping</span>
                                                <span>{{ Number::currency($order->shipping_price, 'LKR') }}</span>
                                            </div>
                                        </li>
                                        <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-semibold bg-gray-50 border text-gray-800 first:rounded-t-lg first:mt-0 last:rounded-b-lg">
                                            <div class="flex items-center justify-between w-full">
                                                <span>Total paid by customer</span>
                                                <span>{{ $order->formattedPrice }}</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div>
                                <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                                    {{ __('Customer Information') }}
                                </h2>
                                <div class="mt-4">
                                    <p class="block text-sm text-gray-700">Name</p>
                                    <p class="mt-1 block font-medium text-sm text-gray-900">{{ $order->user->name }}</p>
                                </div>
                                <div class="mt-4">
                                    <p class="block text-sm text-gray-700">Email</p>
                                    <p class="mt-1 block font-medium text-sm text-gray-900">{{ $order->user->email }}</p>
                                </div>
                            </div>
                            <div class="mt-6">
                                <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                                    {{ __('Address Information') }}
                                </h2>
                                <div class="mt-4">
                                    <p class="block text-sm text-gray-700">Line</p>
                                    <p class="mt-1 block font-medium text-sm text-gray-900">{{ $order->line1 }}, {{ $order->line2 }}</p>
                                </div>
                                <div class="mt-4">
                                    <p class="block text-sm text-gray-700">City</p>
                                    <p class="mt-1 block font-medium text-sm text-gray-900">{{ $order->city }} - {{ $order->postal_code }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        // Order fulfillment
        document.getElementById('fulfillBtn').addEventListener('click', function() {
            axios.put("{{ route('dashboard.orders.update', $order) }}", {
                fulfillment_status: 'fulfilled'
            }).then(response => {
                location.reload();
            }).catch(error => {
                console.error(error);
            });
        });

        // Order refund
        document.getElementById('refundBtn').addEventListener('click', function() {
            axios.post("{{ route('dashboard.orders.refund', $order) }}").then(response => {
                location.reload();
            }).catch(error => {
                console.error(error);
            });
        });
    </script>
    @endpush
</x-app-layout>