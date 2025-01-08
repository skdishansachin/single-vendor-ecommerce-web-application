<x-app-layout title="Notifications">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 text-gray-900">
                    <ul role="list" class="divide-y divide-gray-100">
                        <li class="flex justify-between gap-x-6 py-5">
                            <div class="flex min-w-0 gap-x-4">
                                <div class="min-w-0 flex-auto">
                                    <p class="text-sm font-medium leading-6 text-gray-900">New product Green Hoodie for women Created</p>
                                    <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                                        Due on March 17, 2023 - Created by Leslie Alexander
                                    </p>
                                </div>
                            </div>
                        </li>
                        <li class="flex justify-between gap-x-6 py-5">
                            <div class="flex min-w-0 gap-x-4">
                                <div class="min-w-0 flex-auto">
                                    <p class="text-sm font-medium leading-6 text-gray-900">New product Green Hoodie for women Created</p>
                                    <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                                        Due on March 17, 2023 - Created by Leslie Alexander
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>