<x-base-layout title="My orders">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 sm:py-22 lg:px-8 lg:pt-22">
        <div class="max-w-xl">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Order history</h1>
            <p class="mt-1 text-sm text-gray-500">Check the status of recent orders, manage returns, and download invoices.</p>
        </div>

        <section aria-labelledby="recent-heading" class="mt-8">
            <h2 id="recent-heading" class="sr-only">Recent orders</h2>
            <div class="space-y-16">
                @foreach ($orders as $order)
                <div>
                    <h3 class="sr-only">Order placed on <span>{{ $order->created_at->toFormattedDateString() }}</span></h3>

                    <div class="rounded-lg bg-gray-50 px-4 py-6 sm:flex sm:items-start sm:justify-between sm:space-x-6 sm:px-6 lg:space-x-8">
                        <dl class="flex-auto space-y-6 divide-y divide-gray-200 text-sm text-gray-600 sm:grid sm:grid-cols-3 sm:gap-x-6 sm:space-y-0 sm:divide-y-0 lg:w-1/2 lg:flex-none lg:gap-x-8">
                            <div class="flex justify-between sm:block">
                                <dt class="font-medium text-gray-900">Date placed</dt>
                                <dd class="sm:mt-1">
                                    {{ $order->created_at->toFormattedDateString() }}
                                </dd>
                            </div>
                            <div class="flex justify-between pt-6 sm:block sm:pt-0">
                                <dt class="font-medium text-gray-900">Order number</dt>
                                <dd class="sm:mt-1 uppercase">
                                    {{ $order->formattedId }}
                                </dd>
                            </div>
                            <div class="flex justify-between pt-6 font-medium text-gray-900 sm:block sm:pt-0">
                                <dt>Total amount</dt>
                                <dd class="sm:mt-1">{{ $order->formattedPrice }}</dd>
                            </div>
                        </dl>
                        <div>
                            <span class="{{ $order->payment_status == 'paid' ? 'badge-success' : 'badge-warning' }}">{{ $order->payment_status }}</span>
                            <span class="{{ $order->fulfillment_status == 'fulfilled' ? 'badge-success' : 'badge-warning' }}">{{ $order->fulfillment_status }}</span>
                        </div>
                    </div>

                    <table class="mt-4 w-full text-gray-500 sm:mt-6">
                        <caption class="sr-only">
                            Products
                        </caption>
                        <thead class="sr-only text-left text-sm text-gray-500 sm:not-sr-only">
                            <tr>
                                <th scope="col" class="py-3 pr-8 font-normal sm:w-2/5 lg:w-1/3">Product</th>
                                <th scope="col" class="hidden w-1/5 py-3 pr-8 font-normal sm:table-cell">Price</th>
                                <th scope="col" class="hidden py-3 pr-8 font-normal sm:table-cell">Quantity</th>
                                <th scope="col" class="w-0 py-3 text-right font-normal">Info</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 border-b border-gray-200 text-sm sm:border-t">
                            @foreach ($order->cart->products as $product)
                            <tr>
                                <td class="py-6 pr-8">
                                    <div class="flex items-center">
                                        <img src="{{ $product->getFirstMediaUrl('products') }}" alt="{{ $product->name }}" class="mr-6 h-16 w-16 rounded object-cover object-center" />
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                            <div class="mt-1 sm:hidden">{{ Number::currency($product->pivot->purchase_price, 'LKR') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden py-6 pr-8 sm:table-cell">{{ Number::currency($product->pivot->purchase_price, 'LKR') }}</td>
                                <td class="hidden py-6 pr-8 sm:table-cell">{{ $product->pivot->quantity }}</td>
                                <td class="whitespace-nowrap py-6 text-right font-medium">
                                    <a href="{{ route('products.show', $product) }}" class="text-indigo-600">View<span class="hidden lg:inline"> Product</span><span class="sr-only">, {{ $product->name }}</span></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach
            </div>
        </section>
    </div>
</x-base-layout>