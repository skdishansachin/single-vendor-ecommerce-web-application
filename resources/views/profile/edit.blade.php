<x-base-layout title="Profile edit">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 sm:py-22 lg:px-8 lg:pt-22">
        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')
            <div class="space-y-12 sm:space-y-16">
                <div>
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
                    <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-600">Use a permanent address where you can receive mail.</p>

                    <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <x-input-label class="sm:pt-1.5" for="name" :value="__('Name')" />
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <x-text-input id="name" class="block w-full sm:max-w-xs" type="text" name="name" :value="old('name', $user->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <x-input-label class="sm:pt-1.5" for="email" :value="__('Email address')" />
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <x-text-input id="email" class="block w-full sm:max-w-xs" type="email" name="email" :value="old('email', $user->email)" required autofocus />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                            <label for="country" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Country</label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <p class="mt-1 block font-medium text-sm text-gray-900">Sri Lanka <span class="text-gray-500 pl-3">(At the moment we only support Sri Lanka)</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <x-primary-button>Update</x-primary-button>
            </div>
        </form>
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')
            <div>
                <h2 class="text-base font-semibold leading-7 text-gray-900">Account security</h2>
                <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-600">Manage your account security.</p>

                <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                        <x-input-label class="pt-1.5" for="current_password" :value="__('Current Password')" />
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <x-text-input id="current_password" class="block w-full sm:max-w-xs" type="password" name="current_password" autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                        </div>
                        <x-input-label class="pt-1.5" for="password" :value="__('Password')" />
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <x-text-input id="password" class="block w-full sm:max-w-xs" type="password" name="password" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <x-input-label class="pt-1.5" for="password_confirmation" :value="__('Confirm Password')" />
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <x-text-input id="password_confirmation" class="block w-full sm:max-w-xs" type="password" name="password_confirmation" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <x-primary-button>Update Password</x-primary-button>
            </div>
        </form>
    </div>
</x-base-layout>