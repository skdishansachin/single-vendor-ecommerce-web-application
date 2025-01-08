<x-app-layout title="Shipping profiles">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shipping Profiles') }}
        </h2>
        @can('create shippings')
        <div>
            <a href="{{ route('dashboard.shippings.create') }}">
                <x-primary-button>create</x-primary-button>
            </a>
        </div>
        @endcan
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-white">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-xs font-medium uppercase text-gray-500 sm:pl-6">Name</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase text-gray-500">cost</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase text-gray-500">status</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase text-gray-500">Created at</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($shippings as $shipping)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $shipping->name }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $shipping->cost ? Number::currency($shipping->cost, 'LKR') : 'N/A' }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{!! $shipping->is_active ? '<span class="badge-success">active</span>' : '<span class="badge-info">not active</span>' !!}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $shipping->created_at->toDayDateTimeString() }}</td>
                                        @can('view shippings')
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <a href="{{ route('dashboard.shippings.edit', $shipping) }}" class="text-indigo-600 hover:text-indigo-900">View<span class="sr-only">, {{ $shipping->name }}</span></a>
                                        </td>
                                        @endcan
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($shippings->hasPages())
                            <div class="p-4">{{ $shippings->appends(request()->input())->links('pagination::tailwind') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>