<x-base-layout title="Collection">
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($collections as $collection)
                <a href="{{ route('collections.show', $collection) }}" class="group">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                        <img src="{{ $collection->getFirstMediaUrl('collections') }}" alt="{{ $collection->name }}" loading="lazy" class="h-full w-full object-cover object-center" />
                    </div>
                    <h3 class="mt-4 text-sm text-gray-700">{{ $collection->name }}</h3>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</x-base-layout>