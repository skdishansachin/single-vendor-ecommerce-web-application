<x-base-layout title="{{ $collection->name }} | Collection">
    <div class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $collection->name }}</h1>
            <p class="mt-4 max-w-xl text-sm text-gray-700">{{ $collection->description }}</p>

            <!-- Product grid -->
            <section aria-labelledby="collection-product-heading">
                <div class="mt-8 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    @foreach($collection->products as $product)
                    <div class="group relative">
                        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                            <img src="{{ $product->getFirstMediaUrl('products') }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
                        </div>
                        <h3 class="mt-4 text-sm text-gray-700">
                            <a href="{{ route('products.show', $product) }}">
                                <span class="absolute inset-0"></span>
                                {{ $product->name }}
                            </a>
                        </h3>
                        <p class="mt-1 text-sm font-medium text-gray-900">{{ $product->formattedPrice }}</p>
                    </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</x-base-layout>