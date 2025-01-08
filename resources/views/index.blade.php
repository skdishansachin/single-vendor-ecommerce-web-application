<x-base-layout title="Home">
    <!-- Collections -->
    <section aria-labelledby="collection-heading">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 sm:py-22 lg:px-8 lg:pt-22">
            <div class="md:flex md:items-center md:justify-between">
                <h2 id="collections-heading" class="text-2xl font-bold tracking-tight text-gray-900">Shop by collections</h2>
                <a href="{{ route('collections.index') }}" class="hidden text-sm font-medium text-indigo-600 hover:text-indigo-500 md:block">
                    Shop the collection
                </a>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4 md:gap-y-0 lg:gap-x-8">
                @foreach($collections as $collection)
                <div class="group aspect-h-1 aspect-w-2 overflow-hidden rounded-lg sm:aspect-h-1 sm:aspect-w-1 sm:row-span-2">
                    <img src="{{ $collection->getFirstMediaUrl('collections') }}" alt="{{ $collection->name }}" class="h-full w-full object-cover object-center" />
                    <div aria-hidden="true" class="bg-gradient-to-b from-transparent to-black opacity-50"></div>
                    <div class="flex items-end p-6">
                        <h3 class="font-semibold text-white">
                            <a href="{{ route('collections.show', $collection) }}">
                                <span class="absolute inset-0"></span>
                                {{ $collection->name }}
                            </a>
                        </h3>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-8 text-sm md:hidden">
                <a href="{{ route('collections.index') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Shop the collection
                </a>
            </div>
        </div>
    </section>

    <!-- Trending products -->
    <section aria-labelledby="trending-heading">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 sm:py-22 lg:px-8 lg:pt-22">
            <h2 id="trending-heading" class="text-2xl font-bold tracking-tight text-gray-900">Trending Products</h2>

            <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4 md:gap-y-0 lg:gap-x-8">
                @foreach($products as $product)
                <div class="group relative">
                    <div class="h-56 w-full overflow-hidden rounded-md group-hover:opacity-90 lg:h-72 xl:h-80">
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

    <!-- Collection products -->
    @foreach ($collections as $collection)
    <section aria-labelledby="collection-product-heading">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 sm:py-22 lg:px-8 lg:pt-22">
            <h2 id="collection-product-heading" class="text-2xl font-bold tracking-tight text-gray-900">{{ $collection->name }} Products</h2>

            <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4 md:gap-y-0 lg:gap-x-8">
                @foreach($collection->products as $product)
                <div class="group relative">
                    <div class="h-56 w-full overflow-hidden rounded-md group-hover:opacity-90 lg:h-72 xl:h-80">
                        <img src="{{ $product->getFirstMediaUrl('products') }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center" />
                    </div>
                    <h3 class="mt-4 text-sm text-gray-700">
                        <a href="{{ route('products.show', $product) }}">
                            <span class="absolute inset-0"></span>
                            {{ $product->name }}
                        </a>
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">{{ $collection->name }}</p>
                    <p class="mt-1 text-sm font-medium text-gray-900">{{ $product->formattedPrice }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endforeach
</x-base-layout>