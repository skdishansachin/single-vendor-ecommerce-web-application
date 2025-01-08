<x-base-layout title="Order placed success">
    <div class="bg-white">
        <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
            <div class="max-w-xl">
                <h1 class="text-base font-medium text-indigo-600">Thank you!</h1>
                <p class="mt-2 text-4xl font-bold tracking-tight sm:text-5xl">It's on the way!</p>
                <p class="mt-2 text-base text-gray-500">Your order <span class="uppercase">{{ $order->formattedId }}</span> has shipped and will be with you soon.</p>
            </div>

            <div class="mt-10 border-t border-gray-200">
                <h2 class="sr-only">Your order</h2>

                <h3 class="sr-only">Items</h3>
                @foreach ($order->cart->products as $product)
                <div class="flex space-x-6 border-b border-gray-200 py-10">
                    <img src="{{ $product->getFirstMediaUrl('products') }}" alt="{{ $product->name }}" class="h-20 w-20 flex-none rounded-lg bg-gray-100 object-cover object-center sm:h-40 sm:w-40" />
                    <div class="flex flex-auto flex-col">
                        <div>
                            <h4 class="font-medium text-gray-900">
                                <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                            </h4>
                            <p class="mt-2 text-sm text-gray-600">{!! Str::limit($product->description, 100) !!}</p>
                        </div>
                        <div class="mt-6 flex flex-1 items-end">
                            <dl class="flex space-x-4 divide-x divide-gray-200 text-sm sm:space-x-6">
                                <div class="flex">
                                    <dt class="font-medium text-gray-900">Quantity</dt>
                                    <dd class="ml-2 text-gray-700">{{ $product->pivot->quantity }}</dd>
                                </div>
                                <div class="flex pl-4 sm:pl-6">
                                    <dt class="font-medium text-gray-900">Unit price</dt>
                                    <dd class="ml-2 text-gray-700">{{ Number::currency($product->pivot->purchase_price, 'LKR') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="sm:ml-40 sm:pl-6">
                    <h3 class="sr-only">Your information</h3>

                    <h4 class="sr-only">Addresses</h4>
                    <dl class="grid grid-cols-2 gap-x-6 py-10 text-sm">
                        <div>
                            <dt class="font-medium text-gray-900">Shipping address</dt>
                            <dd class="mt-2 text-gray-700">
                                <address class="not-italic">
                                    <span class="block">{{ $order->line1 }}</span>
                                    <span class="block">{{ $order->line2 }}</span>
                                    <span class="block">{{ $order->city }} - {{ $order->postal_code }}</span>
                                </address>
                            </dd>
                        </div>
                    </dl>

                    <h3 class="sr-only">Summary</h3>

                    <dl class="space-y-6 border-t border-gray-200 pt-10 text-sm">
                        <div class="flex justify-between">
                            <dt class="font-medium text-gray-900">Subtotal</dt>
                            <dd class="text-gray-700">{{ Number::currency($product->pivot->subtotal, 'LKR') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-gray-900">Shipping</dt>
                            <dd class="text-gray-700">{{ Number::currency($order->shipping_price, 'LKR') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="font-medium text-gray-900">Total</dt>
                            <dd class="text-gray-900">{{ $order->formattedPrice }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-base-layout>