<x-app-layout title="Invite user">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invite user') }}
        </h2>
        <div>
            <x-primary-button form="invite_user_form">invite</x-primary-button>
            <a href="{{ route('dashboard.invitations.index') }}" class="ms-4">
                <x-secondary-button>back</x-secondary-button>
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('dashboard.invitations') }}" method="post" id="invite_user_form">
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
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" autocomplete="email" required />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <x-input-label for="roles" :value="__('Roles')" />
                                <div class="mt-2 space-y-6">
                                    <div class="relative flex gap-x-3">
                                        <div class="flex h-6 items-center">
                                            <input id="product" name="roles[]" type="checkbox" value="product" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                        </div>
                                        <div class="text-sm leading-6">
                                            <label for="product" class="font-medium text-gray-900">Manage products</label>
                                            <p class="text-gray-500">User will able to view, create, edit and delete products and collections.</p>
                                        </div>
                                    </div>
                                    <div class="relative flex gap-x-3">
                                        <div class="flex h-6 items-center">
                                            <input id="order" name="roles[]" type="checkbox" value="order" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                        </div>
                                        <div class="text-sm leading-6">
                                            <label for="order" class="font-medium text-gray-900">Manage orders</label>
                                            <p class="text-gray-500">User will able to view, edit, fulfil, cancel, refund and archive orders.</p>
                                        </div>
                                    </div>
                                    <div class="relative flex gap-x-3">
                                        <div class="flex h-6 items-center">
                                            <input id="user" name="roles[]" type="checkbox" value="user" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                        </div>
                                        <div class="text-sm leading-6">
                                            <label for="user" class="font-medium text-gray-900">Manage users</label>
                                            <p class="text-gray-500">Ability to manage accounts and invite users</p>
                                        </div>
                                    </div>
                                    <div class="ml-5 relative flex gap-x-3">
                                        <div class="flex h-6 items-center">
                                            <input id="update_users_access" name="permissions[]" type="checkbox" value="update users access" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                        </div>
                                        <div class="text-sm leading-6">
                                            <label for="update_users_access" class="font-medium text-gray-900">Ban and Unban users</label>
                                            <p class="text-gray-500">User will be able to ban and unban users.</p>
                                        </div>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('roles')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
    <script>
        const dependencies = {
            'update products prices': ['product'],
            'update users access': ['user']
        };

        // Check dependent permissions when a main permission is checked
        const updateDependencies = (permission) => {
            if (dependencies[permission]) {
                dependencies[permission].forEach(dep => {
                    const depCheckbox = document.getElementById(dep.split(' ').join('_'));
                    depCheckbox.checked = true;
                });
            }
        };

        // Uncheck main permission if any dependent permission is unchecked
        const validateDependencies = () => {
            for (const mainPerm in dependencies) {
                const mainCheckbox = document.getElementById(mainPerm.split(' ').join('_'));
                if (mainCheckbox.checked) {
                    let allDepsChecked = true;
                    dependencies[mainPerm].forEach(dep => {
                        const depCheckbox = document.getElementById(dep.split(' ').join('_'));
                        if (!depCheckbox.checked) {
                            allDepsChecked = false;
                        }
                    });
                    if (!allDepsChecked) {
                        mainCheckbox.checked = false;
                    }
                }
            }
        };

        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', (event) => {
                const permission = event.target.value;
                if (event.target.checked) {
                    updateDependencies(permission);
                }
                validateDependencies();
            });
        });
    </script>
    @endpush
</x-app-layout>