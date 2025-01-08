<x-base-layout title="Search">
    <div class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="flex items-baseline">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">You searched for</h1>
                <form action="{{ route('search') }}" method="get">
                    <div class="relative w-full max-w-lg">
                        <input type="text" name="query" autocomplete="off" class="border-0 bg-transparent text-3xl placeholder:text-3xl text-gray-900 placeholder-gray-400 focus:ring-0 w-full py-2" placeholder="Men's hoodie..." value="{{ $query }}" />
                    </div>
                </form>
            </div>

            <!-- Search result -->
            @if (!empty($results))
            <section aria-labelledby="products-heading">
                <h2 id="products-heading" class="sr-only">Products</h2>

                <div class="mt-8 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                    @foreach ($results as $product)
                    <a href="{{ route('products.show', $product) }}" class="group">
                        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                            <img src="{{ $product->getFirstMediaUrl('products') }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center group-hover:opacity-90" />
                        </div>
                        <h3 class="mt-4 text-sm text-gray-700">{{ $product->name }}</h3>
                        <p class="mt-1 text-lg font-medium text-gray-900">{{ $product->formattedPrice }}</p>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Collection products -->
            <section aria-labelledby="collections-heading">
                <h2 id="collections-heading" class="sr-only">Collections</h2>

                <div class="mt-8 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                    @foreach ($collections as $collection)
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
            </section>
        </div>
    </div>
</x-base-layout>