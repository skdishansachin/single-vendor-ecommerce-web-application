<x-app-layout title="Product edit">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product edit') }}
        </h2>
        <div>
            <x-primary-button form="product_edit_form">edit</x-primary-button>
            <a href="{{ route('dashboard.products.index') }}" class="ms-4">
                <x-secondary-button>back</x-secondary-button>
            </a>
        </div>
    </x-slot>
    <x-alert :type="session('type')" :message="session('message')" />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('dashboard.products.update', $product) }}" method="post" enctype="multipart/form-data" id="product_edit_form">
                @method('put')
                @csrf
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 md:col-span-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <div>
                                    <x-input-label for="name" :value="__('Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div class="mt-4">
                                    <x-input-label for="description" :value="__('Description')" />
                                    <div class="mt-1 bg-white border border-gray-300 rounded-md shadow-sm overflow-hidden">
                                        <div id="hs-editor-tiptap">
                                            <div class="flex align-middle gap-x-0.5 border-b border-gray-200 p-2">
                                                <button class="size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" type="button" data-hs-editor-bold="">
                                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M14 12a4 4 0 0 0 0-8H6v8"></path>
                                                        <path d="M15 20a4 4 0 0 0 0-8H6v8Z"></path>
                                                    </svg>
                                                </button>
                                                <button class="size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" type="button" data-hs-editor-italic="">
                                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <line x1="19" x2="10" y1="4" y2="4"></line>
                                                        <line x1="14" x2="5" y1="20" y2="20"></line>
                                                        <line x1="15" x2="9" y1="4" y2="20"></line>
                                                    </svg>
                                                </button>
                                                <button class="size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" type="button" data-hs-editor-underline="">
                                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M6 4v6a6 6 0 0 0 12 0V4"></path>
                                                        <line x1="4" x2="20" y1="20" y2="20"></line>
                                                    </svg>
                                                </button>
                                                <button class="size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" type="button" data-hs-editor-strike="">
                                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M16 4H9a3 3 0 0 0-2.83 4"></path>
                                                        <path d="M14 12a4 4 0 0 1 0 8H6"></path>
                                                        <line x1="4" x2="20" y1="12" y2="12"></line>
                                                    </svg>
                                                </button>
                                                <button class="size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" type="button" data-hs-editor-link="">
                                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="h-[10rem] overflow-auto p-3" data-hs-editor-field=""></div>
                                        </div>
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                                </div>

                                <div class="mt-4 flex items-start gap-5">
                                    <div class="w-full">
                                        <x-input-label for="price" :value="__('Price')" />
                                        <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full" :value="old('price', $product->price)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('price')" />
                                    </div>
                                    <div class="w-full">
                                        <x-input-label for="available" :value="__('Available')" />
                                        <x-text-input id="available" name="available" type="number" class="mt-1 block w-full" :value="old('available', $product->available)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('available')" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-8">
                            <div class="mt-4">
                                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <div class="p-6 text-gray-900">
                                        <div>
                                            <x-input-label for="media" :value="__('Media')" />
                                            <div class="mt-2 rounded-lg border border-dashed border-gray-900/25 px-6 pb-5">
                                                <div class="flex justify-center">
                                                    <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                                        <label for="media" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                                            <span>Upload a files</span>
                                                            <input id="media" name="media[]" type="file" multiple class="sr-only" />
                                                        </label>
                                                        <p class="pl-1">(PNG, JPG, GIF up to 5MB)</p>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-3 gap-5 pt-5" id="preview-container">
                                                    @foreach($product->getMedia('products') as $image)
                                                    <image class="w-full h-full object-cover rounded-lg transition duration-500 ease-in-out" alt="{{ $product->name }}" src="{{ $image->getUrl() }}" loading="lazy" />
                                                    @endforeach
                                                </div>
                                            </div>
                                            <x-input-error class="mt-2" :messages="$errors->get('media')" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-4">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <div>
                                    <x-input-label for="collection" :value="__('Collection')" />
                                    <div class="mt-2">
                                        @if($collections->isNotEmpty())
                                        <select name="collection" id="collection" class="mt-2 block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            @foreach($collections as $collection)
                                            <option value="{{ $collection->id }}" {{ old('collection', $product->collection_id) == $collection->id ? 'selected' : '' }}>{{ $collection->name }}</option>
                                            @endforeach
                                        </select>
                                        @else
                                        <p class="text-sm text-gray-500 leading-6">Create a new<a href="{{ route('dashboard.collections.create') }}" class="text-indigo-500 underline">collection</a> first.</p>
                                        @endif
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('collection')" />
                                </div>
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
                const files = Array.from(event.target.files);

                if (files.length === 0) {
                    console.log("No images selected by the user.");
                    return;
                }

                previewContainer.innerHTML = ''; // Clear existing previews

                files.forEach(file => {
                    if (!file.type.startsWith('image/')) {
                        console.log(`File ${file.name} is not an image.`);
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const img = createImagePreview(event.target.result, file.name);
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
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
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        var el = document.getElementById('preview-container');
        var sortable = Sortable.create(el);
    </script>

    <script type="module">
        // Tiptap
        import {
            Editor
        } from 'https://esm.sh/@tiptap/core';
        import StarterKit from 'https://esm.sh/@tiptap/starter-kit';
        import Underline from 'https://esm.sh/@tiptap/extension-underline';
        import Link from 'https://esm.sh/@tiptap/extension-link';

        const editor = new Editor({
            content: `{!! old('description', $product->description) !!}`,
            element: document.querySelector('#hs-editor-tiptap [data-hs-editor-field]'),
            extensions: [
                StarterKit.configure({
                    Bold: {
                        HTMLAttributes: {
                            class: 'font-bold'
                        }
                    },
                }),
                Underline,
                Link.configure({
                    HTMLAttributes: {
                        class: 'inline-flex items-center gap-x-1 text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium'
                    }
                }),
            ]
        });
        const actions = [{
                id: '#hs-editor-tiptap [data-hs-editor-bold]',
                fn: () => editor.chain().focus().toggleBold().run()
            },
            {
                id: '#hs-editor-tiptap [data-hs-editor-italic]',
                fn: () => editor.chain().focus().toggleItalic().run()
            },
            {
                id: '#hs-editor-tiptap [data-hs-editor-underline]',
                fn: () => editor.chain().focus().toggleUnderline().run()
            },
            {
                id: '#hs-editor-tiptap [data-hs-editor-strike]',
                fn: () => editor.chain().focus().toggleStrike().run()
            },
            {
                id: '#hs-editor-tiptap [data-hs-editor-link]',
                fn: () => {
                    const url = window.prompt('URL');
                    editor.chain().focus().extendMarkRange('link').setLink({
                        href: url
                    }).run();
                }
            },
        ];

        actions.forEach(({
            id,
            fn
        }) => {
            const action = document.querySelector(id);

            if (action === null) return;

            action.addEventListener('click', fn);
        });

        const form = document.getElementById('product_edit_form');
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Get the editor content
            const editorContent = editor.getHTML();


            // Create a hidden input to store the editor content
            let hiddenInput = form.querySelector('input[name="description"]');
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'description';
                form.appendChild(hiddenInput);
            }
            hiddenInput.value = editorContent;

            // Submit the form
            form.submit();
        });
    </script>
    @endpush
</x-app-layout>