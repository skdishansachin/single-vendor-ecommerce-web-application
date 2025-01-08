<x-app-layout title="User Details">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User details') }}
        </h2>
        <div class="flex items-center gap-4">
            @if($canBanUser)
            <x-primary-button id="banBtn">
                {{ $user->banned() ? 'unban' : 'ban' }}
            </x-primary-button>
            @endif
            <a href="{{ route('dashboard.users.index') }}">
                <x-secondary-button>Back</x-secondary-button>
            </a>
        </div>
    </x-slot>
    <x-alert :message="session('message')" />
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            @if (!is_null($lastOrder) || $user->hasRole('customer'))
                            <div>
                                <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                                    {{ __('Last order placed') }}
                                </h2>
                                @if (is_null($lastOrder))
                                <div class="mt-4">
                                    <p class="mt-1 block font-medium text-sm text-gray-900">User have no order yet!</p>
                                </div>
                                @else
                                <div class="mt-4 flex items-center justify-between">
                                    <p class="block text-sm text-gray-700">
                                        Order placed: {{ $lastOrder->created_at->toDayDateTimeString() }}
                                    </p>
                                    <div>
                                        <span class="{{ $lastOrder->payment_status == 'paid' ? 'badge-success' : 'badge-warning' }}">{{ $lastOrder->payment_status }}</span>
                                        <span class="{{ $lastOrder->fulfillment_status == 'fulfilled' ? 'badge-success' : 'badge-warning' }}">{{ $lastOrder->fulfillment_status }}</span>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="py-2 text-gray-900">
                                        <div class="flex flex-col">
                                            <div class="overflow-x-auto">
                                                <div class="min-w-full inline-block align-middle">
                                                    <div class="overflow-hidden">
                                                        <table class="min-w-full divide-y divide-gray-200">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" class="pe-4 py-3 text-start text-xs font-medium text-gray-500 uppercase">Name</th>
                                                                    <th scope="col" class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase">Qty</th>
                                                                    <th scope="col" class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase">Price</th>
                                                                    <th scope="col" class="px-4 py-3 text-start text-xs font-medium text-gray-500 uppercase">Total</th>
                                                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                                        <span class="sr-only">Edit</span>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-200">

                                                                @foreach($lastOrder->cart->products as $product)
                                                                <tr>
                                                                    <td class="pe-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                                        <div class="flex items-center">
                                                                            <img class="hidden md:block w-12 h-12 max-w-full object-cover rounded-lg mr-5" src="{{ $product->getFirstMedia('products')->getUrl() }}" alt="{{ $product->name }}" loading="lazy" />
                                                                            {{ $product->name }}
                                                                        </div>
                                                                    </td>
                                                                    <td class="p-4 whitespace-nowrap text-sm text-gray-800"><span class="pe-1">x</span>{{ $product->pivot->quantity }}</td>
                                                                    <td class="p-4 whitespace-nowrap text-sm text-gray-800">{{ Number::currency($product->pivot->purchase_price, 'LKR') }}</td>
                                                                    <td class="p-4 whitespace-nowrap text-sm text-gray-800">{{ Number::currency($product->pivot->subtotal, 'LKR') }}</td>
                                                                    <td class="p-4 whitespace-nowrap text-sm text-gray-800">
                                                                        <a href="{{ route('dashboard.orders.show', $lastOrder) }}" class="text-indigo-600 hover:text-indigo-900">View<span class="sr-only">, order {{ $lastOrder->id }}</span></a>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif

                            @if(!$user->hasRole('customer'))
                            <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                                {{ __('User Roles & Permissions') }}
                            </h2>
                            <div class="mt-4">
                                <ul>
                                    @foreach ($user->roles as $role)
                                    <li class="mt-1 ml-5 capitalize text-sm text-gray-700 list-disc list-item">
                                        {{ $role->name }} management
                                    </li>
                                    @endforeach
                                    @foreach ($user->permissions as $permission)
                                    <li class="mt-1 ml-5 capitalize text-sm text-gray-700 list-disc list-item">
                                        {{ $permission->name }} management
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div>
                                <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                                    {{ __('User Information') }}
                                </h2>
                                <div class="mt-4">
                                    <p class="block text-sm text-gray-700">Name</p>
                                    <p class="mt-1 block font-medium text-sm text-gray-900">{{ $user->name }}</p>
                                </div>
                                <div class="mt-4">
                                    <p class="block text-sm text-gray-700">Email</p>
                                    <p class="mt-1 block font-medium text-sm text-gray-900">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        const banBtn = document.getElementById('banBtn');
        if (banBtn) {
            banBtn.addEventListener('click', function(event) {
                axios.put("{{ route('dashboard.users.update', $user) }}", {})
                    .then(response => {
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error(error);
                    });
            })
        }
    </script>
    @endpush
</x-app-layout>