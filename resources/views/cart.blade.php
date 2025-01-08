<x-base-layout title="Cart">
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 lg:max-w-7xl lg:px-8">
        <h1 class="pb-8 text-xl font-bold tracking-tight text-gray-900 sm:text-3xl">Shopping Cart</h1>

        <div class="lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
            <section aria-labelledby="cart-heading" class="lg:col-span-7">
                <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>

                <ul role="list" class="divide-y divide-gray-200 border-b border-t border-gray-200">
                    @forelse($cart->products as $product)
                    <li class="flex py-6 sm:py-10">
                        <div class="flex-shrink-0">
                            <img src="{{ $product->getFirstMediaUrl('products') }}" alt="{{ $product->name }}" loading="lazy" class="h-24 w-24 rounded-md object-cover object-center sm:h-48 sm:w-48" />
                        </div>

                        <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
                            <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                <div>
                                    <div class="flex justify-between">
                                        <h3 class="text-sm">
                                            <a href="{{ route('products.show', $product) }}" class="font-medium text-gray-700 hover:text-gray-800">{{ $product->name }}</a>
                                        </h3>
                                    </div>
                                    <div class="mt-1 flex text-sm">
                                        <p class="text-gray-500">{{ $product->collection->name }}</p>
                                    </div>
                                    <p class="mt-1 text-sm font-medium text-gray-900">{{ $product->formattedPrice }}</p>
                                </div>

                                <div class="mt-4 sm:mt-0 sm:pr-9">
                                    <label for="quantity-{{ $product->id }}" class="sr-only">Quantity, {{ $product->name }}</label>
                                    <select id="quantity-{{ $product->id }}" name="quantity" class="quantity-select max-w-full rounded-md border border-gray-300 py-1.5 text-left text-base font-medium leading-5 text-gray-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 sm:text-sm" data-product-id="{{ $product->id }}">
                                        <option value="1" {{ $product->pivot->quantity == 1 ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ $product->pivot->quantity == 2 ? 'selected' : '' }}>2</option>
                                        <option value="3" {{ $product->pivot->quantity == 3 ? 'selected' : '' }}>3</option>
                                        <option value="4" {{ $product->pivot->quantity == 4 ? 'selected' : '' }}>4</option>
                                        <option value="5" {{ $product->pivot->quantity == 5 ? 'selected' : '' }}>5</option>
                                        <option value="6" {{ $product->pivot->quantity == 6 ? 'selected' : '' }}>6</option>
                                        <option value="7" {{ $product->pivot->quantity == 7 ? 'selected' : '' }}>7</option>
                                        <option value="8" {{ $product->pivot->quantity == 8 ? 'selected' : '' }}>8</option>
                                    </select>

                                    <div class="absolute right-0 top-0">
                                        <button type="button" class="remove-btn -m-2 inline-flex p-2 text-gray-400 hover:text-gray-500" data-product-id="{{ $product->id }}">
                                            <span class="sr-only">Remove</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="flex py-6 sm:py-10">
                        <p class="text-center md:text-lg lg:text-xl text-gray-500">Your cart is empty...</p>
                    </li>
                    @endforelse
                </ul>
            </section>

            @if ($cart->subtotal > 0)
            <!-- Order summary -->
            <section aria-labelledby="summary-heading" class="mt-16 rounded-lg bg-gray-50 px-4 py-6 sm:p-6 lg:col-span-5 lg:mt-0 lg:p-8">
                <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Order summary</h2>

                <dl class="mt-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-600">You can choose your preferd shipping option in checkout.</p>
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                        <dt class="text-base font-medium text-gray-900">Cart total</dt>
                        <dd class="text-base font-medium text-gray-900">{{ Number::currency($cart->subtotal, 'LKR') }}</dd>
                    </div>
                </dl>

                <div class="mt-6">
                    <form method="post" action="{{ route('checkout') }}">
                        @csrf
                        <button type="submit" class="w-full rounded-md border border-transparent bg-indigo-600 px-4 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Checkout</button>
                    </form>
                </div>
            </section>
            @endif
        </div>

        <!-- Related products -->
        <section aria-labelledby="related-heading">
            <div class="pt-8">
                <h2 id="related-heading" class="text-2xl font-bold tracking-tight text-gray-900">You might also like...</h2>

                <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4 md:gap-y-0 lg:gap-x-8">
                    @foreach($relatedProducts as $product)
                    <div class="group relative">
                        <div class="h-56 w-full overflow-hidden rounded-md group-hover:opacity-90 lg:h-72">
                            <img src="{{ $product->getFirstMediaUrl('products') }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center" />
                        </div>
                        <h3 class="mt-4 text-sm text-gray-700">
                            <a href="{{ route('products.show', $product) }}">
                                <span class="absolute inset-0"></span>
                                {{ $product->name }}
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">{{ $product->collection->name }}</p>
                        <p class="mt-1 text-sm font-medium text-gray-900">{{ $product->formattedPrice }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    @push('scripts')
    <script>
        document.querySelectorAll('.quantity-select').forEach(select => {
            select.addEventListener('change', function(event) {
                const productId = event.currentTarget.getAttribute('data-product-id');
                const quantity = parseInt(event.currentTarget.value, 10);
                updateCartQty(productId, quantity);
            });
        });

        document.querySelectorAll('.remove-btn').forEach(button => {
            button.addEventListener('click', function(event) {
                const productId = event.currentTarget.getAttribute('data-product-id');
                removeFromCart(productId);
            });
        });

        function updateCartQty(productId, quantity) {
            axios.put("{{ route('cart.update') }}", {
                product_id: productId,
                quantity: quantity
            }).then(response => {
                location.reload();
            }).catch(error => {
                console.log(error);
            });
        }

        function removeFromCart(productId) {
            axios.delete("{{ route('cart.destroy') }}", {
                data: {
                    product_id: productId
                }
            }).then(response => {
                location.reload();
            }).catch(error => {
                console.log(error);
            });
        }
    </script>
    @endpush
</x-base-layout>