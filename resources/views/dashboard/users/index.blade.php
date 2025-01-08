<x-app-layout title="Users">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <div class="sm:hidden">
                    <form action="{{ route('dashboard.users.index') }}" method="get" onclick="this.closest('form').submit();">
                        <label for="tab" class="sr-only">Select a tab</label>
                        <select id="tab" name="tab" class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            <option selected value="customers">Customers</option>
                            <option value="members">Members</option>
                            <option value="banned">Banned</option>
                        </select>
                    </form>
                </div>
                <div class="hidden sm:block">
                    <nav class="flex space-x-4" aria-label="Tabs">
                        <a href="{{ route('dashboard.users.index', ['tab' => 'customers']) }}" class="{{ $tab === 'customers' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700' }} rounded-md px-3 py-2 text-sm font-medium">
                            Customers
                        </a>
                        <a href="{{ route('dashboard.users.index', ['tab' => 'members']) }}" class="{{ $tab === 'members' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700' }} rounded-md px-3 py-2 text-sm font-medium">
                            Members
                        </a>
                        <a href="{{ route('dashboard.users.index', ['tab' => 'banned']) }}" class="{{ $tab === 'banned' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700' }} rounded-md px-3 py-2 text-sm font-medium">
                            Banned
                        </a>
                    </nav>
                </div>
            </div>

            <div class="flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-white">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-xs font-medium uppercase text-gray-500 sm:pl-6">Name</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase text-gray-500">Email</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase text-gray-500">Joined at</th>
                                        @if(Str::is($tab, 'banned'))
                                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase text-gray-500">Banned at</th>
                                        @endif
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($users as $user)
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $user->name }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->created_at->toFormattedDateString() }}</td>
                                        @if($user->banned())
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->banned_at->toFormattedDateString() }}</td>
                                        @endif
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <a href="{{ route('dashboard.users.show', $user) }}" class="text-indigo-600 hover:text-indigo-900">View<span class="sr-only">, {{ $user->name }}</span></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($users->hasPages())
                            <div class="p-4">{{ $users->appends(request()->input())->links('pagination::tailwind') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>