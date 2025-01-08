<x-app-layout title="Create shipping profile">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create shipping profile') }}
        </h2>
        <div>
            <x-primary-button form="shipping_profile_form">Create</x-primary-button>
            <a href="{{ route('dashboard.shippings.index') }}" class="ms-4">
                <x-secondary-button>Back</x-secondary-button>
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('dashboard.shippings.store') }}" method="post" id="shipping_profile_form">
                @csrf
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 md:col-span-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <div class="flex items-start gap-6">
                                    <div class="w-full">
                                        <x-input-label for="name" :value="__('Name')" />
                                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>
                                    <div class="w-full" id="costField">
                                        <x-input-label for="cost" :value="__('Cost')" />
                                        <x-text-input id="cost" class="block mt-1 w-full" type="text" name="cost" step="0.01" :value="old('cost')" />
                                        <x-input-error :messages="$errors->get('cost')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="flex items-center gap-6 mt-4">
                                    <div class="w-full" id="shippingMaxDurationField">
                                        <x-input-label for="max_delivery_estimate" :value="__('Max delivery estimate')" />
                                        <x-text-input id="max_delivery_estimate" class="block mt-1 w-full" type="text" name="max_delivery_estimate" :value="old('max_delivery_estimate', 1)" required />
                                        <x-input-error :messages="$errors->get('max_delivery_estimate')" class="mt-2" />
                                    </div>
                                    <div class="w-full" id="shippingMinDurationField">
                                        <x-input-label for="min_delivery_estimate" :value="__('Min delivery estimate')" />
                                        <x-text-input id="min_delivery_estimate" class="block mt-1 w-full" type="text" name="min_delivery_estimate" :value="old('min_delivery_estimate', 1)" required />
                                        <x-input-error :messages="$errors->get('min_delivery_estimate')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <x-input-label for="description" :value="__('Description (optional)')" />
                                    <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description') }}</textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>
                                <div class="mt-4 flex items-start gap-5">
                                    <div class="relative flex gap-x-3">
                                        <div class="flex h-6 items-center">
                                            <input id="is_free" name="is_free" type="checkbox" {{ old('is_free') ? 'checked' : '' }} value="1" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                                        </div>
                                        <div class="text-sm leading-6">
                                            <label for="is_free" class="font-medium text-gray-900">Free shipping</label>
                                            <p class="text-gray-500">Free shipping without any string attached.</p>
                                        </div>
                                    </div>
                                    <div class="relative flex gap-x-3">
                                        <div class="flex h-6 items-center">
                                            <input id="is_active" name="is_active" type="checkbox" {{ old('is_active') ? 'checked' : '' }} value="1" checked class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                                        </div>
                                        <div class="text-sm leading-6">
                                            <label for="is_active" class="font-medium text-gray-900">Active</label>
                                            <p class="text-gray-500">This shipping profile is public and ready to use.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <h3 class="text-md font-medium text-gray-900">Shipping Conditions</h3>
                                    <div id="conditions-container" class="mt-2"></div>
                                    <x-primary-button type="button" id="add-condition" class="mt-2">
                                        Add Condition
                                    </x-primary-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('shipping_profile_form');
            if (!form) return; // Exit if we're not on the shipping form page

            const isFreeCheckbox = document.getElementById('is_free');
            const costField = document.getElementById('costField');
            const costInput = document.getElementById('cost');
            const shippingMaxDurationField = document.getElementById('shippingMaxDurationField');
            const shippingMaxDurationInput = document.getElementById('max_delivery_estimate');
            const shippingMinDurationField = document.getElementById('shippingMinDurationField');
            const shippingMinDurationInput = document.getElementById('min_delivery_estimate');
            const addConditionButton = document.getElementById('add-condition');
            const conditionsContainer = document.getElementById('conditions-container');
            let conditionCount = 0;

            function updateFormFields() {
                if (isFreeCheckbox.checked) {
                    costField.style.display = 'none';
                    costInput.value = '';
                    costInput.removeAttribute('required');
                } else {
                    costField.style.display = 'block';
                    costInput.setAttribute('required', 'required');
                }
            }

            function addCondition() {
                conditionCount++;
                const conditionHtml = `
                    <div class="condition-row mt-2 flex items-center space-x-2">
                        <select name="conditions[${conditionCount}][type]" class="block rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option value="min_total">Minimum Total</option>
                            <option value="max_total">Maximum Total</option>
                            <option value="min_items">Minimum Items</option>
                            <option value="max_items">Maximum Items</option>
                        </select>
                        <x-text-input type="number" name="conditions[${conditionCount}][value]" placeholder="Value" required />
                        <x-danger-button type="button" class="remove-condition">Remove</x-danger-button>
                    </div>
                `;
                conditionsContainer.insertAdjacentHTML('beforeend', conditionHtml);
            }

            function removeCondition(event) {
                if (event.target.classList.contains('remove-condition')) {
                    event.target.closest('.condition-row').remove();
                }
            }

            isFreeCheckbox.addEventListener('change', updateFormFields);
            addConditionButton.addEventListener('click', addCondition);
            conditionsContainer.addEventListener('click', removeCondition);

            updateFormFields();
        });
    </script>
</x-app-layout>