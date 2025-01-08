<x-base-layout title="{{ $product->name }}">
    <!-- Product overview -->
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-14 sm:px-6 sm:py-22 lg:grid lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8 lg:pt-22">
            <!-- Product details -->
            <div class="lg:max-w-lg lg:self-start">
                <nav aria-label="Breadcrumb">
                    <ol role="list" class="flex items-center space-x-2">
                        <li>
                            <div class="flex items-center text-sm">
                                <a href="{{ route('collections.show', $product->collection) }}" class="font-medium text-gray-500 hover:text-gray-900">{{ $product->collection->name }}</a>
                                <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="ml-2 h-5 w-5 flex-shrink-0 text-gray-300">
                                    <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                </svg>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center text-sm">
                                <p class="font-medium text-gray-500 hover:text-gray-900">{{ $product->name }}</p>
                            </div>
                        </li>
                    </ol>
                </nav>

                <div class="mt-4">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ $product->name }}</h1>
                </div>

                <section aria-labelledby="information-heading" class="mt-4">
                    <h2 id="information-heading" class="sr-only">Product information</h2>

                    <div class="flex items-center">
                        <p class="text-lg text-gray-900 sm:text-xl">{{ $product->formattedPrice }}</p>
                    </div>

                    <div class="mt-4 space-y-6">
                        <p class="text-base text-gray-500">
                            {!! $product->description !!}
                        </p>
                    </div>

                    @if( $product->available > 0)
                    <div class="mt-6 flex items-center">
                        <svg class="h-5 w-5 flex-shrink-0 text-green-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        <p class="ml-2 text-sm text-gray-500">In stock and ready to ship</p>
                    </div>
                    @elseif ($product->available == 0)
                    <div class="mt-6 flex items-center">
                        <svg class="h-5 w-5 flex-shrink-0 text-red-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        <p class="ml-2 text-sm text-gray-500">Out of stock and not ready to ship</p>
                    </div>
                    @endif
                </section>
            </div>

            <!-- Product image -->
            <div class="mt-10 lg:col-start-2 lg:row-span-2 lg:mt-0 lg:self-center">
                <div class="embla">
                    <div class="embla__viewport">
                        <div class="embla__container">
                            @foreach($product->getMedia('products') as $image)
                            <div class="embla__slide">
                                <div class="embla__slide__number">
                                    <img src="{{ $image->getUrl() }}" alt="{{ $product->name }}" loading="lazy" class="w-full h-full rounded" />
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="embla-thumbs">
                        <div class="embla-thumbs__viewport">
                            <div class="embla-thumbs__container">
                                <!-- I removed the `embla-thumbs__slide--selected` -->
                                @foreach($product->getMedia('products') as $image)
                                <div class="embla-thumbs__slide">
                                    <button type="button" class="embla-thumbs__slide__number">
                                        <img src="{{ $image->getUrl() }}" alt="{{ $product->name }}" loading="lazy" class="w-full h-full rounded" />
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product form -->
            <div class="mt-10 lg:col-start-1 lg:row-start-2 lg:max-w-lg lg:self-start">
                <section aria-labelledby="options-heading">
                    <h2 id="options-heading" class="sr-only">Product options</h2>
                    <div class="mt-10">
                        <form method="POST" action="{{ route('cart.store') }}">
                            @csrf
                            <input type="hidden" name="product" value="{{ $product->id }}">
                            <button type="submit" class="flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-50">Add to bag</button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Trending products -->
    <section aria-labelledby="trending-heading">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 sm:py-22 lg:px-8 lg:pt-22">
            <h2 id="trending-heading" class="text-2xl font-bold tracking-tight text-gray-900">Trending Products</h2>

            <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4 md:gap-y-0 lg:gap-x-8">
                @foreach($relatedProducts as $product)
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

    @push('scripts')
    <script src="https://unpkg.com/embla-carousel/embla-carousel.umd.js"></script>
    @vite('resources/js/embla.js')
    @endpush
</x-base-layout>