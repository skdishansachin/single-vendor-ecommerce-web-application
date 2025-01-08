<x-app-layout title="Create collection">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Collection create') }}
        </h2>
        <div>
            <x-primary-button form="collection_create_form">create</x-primary-button>
            <a href="{{ route('dashboard.collections.index') }}" class="ms-4">
                <x-secondary-button>back</x-secondary-button>
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('dashboard.collections.store') }}" method="post" enctype="multipart/form-data" id="collection_create_form">
                @csrf
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 md:col-span-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <div>
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                <div class="mt-4">
                                    <x-input-label for="description" :value="__('Description (optional)')" />
                                    <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-8 md:col-span-4">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <div class="flex items-baseline justify-between text-sm leading-6 text-gray-600">
                                    <p class="font-medium text-sm text-gray-900">Media</p>
                                    <label for="media" class="relative cursor-pointer rounded-sm text-indigo-500 font-medium focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Upload an image</span>
                                        <input accept="image/*" type='file' id="media" name="media" class="sr-only" />
                                    </label>
                                </div>
                                <div id="preview-container"></div>
                                <x-input-error class="mt-2" :messages="$errors->get('media')" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('media');
            const previewContainer = document.getElementById('preview-container');

            input.addEventListener('change', handleFileSelect);

            function handleFileSelect(event) {
                const file = event.target.files[0];

                if (!file) {
                    console.log("No image selected by the user.");
                    return;
                }

                if (!file.type.startsWith('image/')) {
                    console.log(`File ${file.name} is not an image.`);
                    return;
                }

                previewContainer.innerHTML = ''; // Clear existing preview

                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = createImagePreview(event.target.result, file.name);
                    previewContainer.classList.add('mt-4');
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            }

            function createImagePreview(src, alt) {
                const img = document.createElement('img');
                img.classList.add('w-full', 'h-full', 'object-cover', 'rounded-lg', 'opacity-0', 'transition', 'duration-500', 'ease-in-out');
                img.alt = alt;
                img.src = src;

                setTimeout(() => img.classList.remove('opacity-0'), 50);

                return img;
            }
        });
    </script>
    @endpush
</x-app-layout>