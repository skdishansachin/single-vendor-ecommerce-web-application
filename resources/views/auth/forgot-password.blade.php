<x-base-layout title="Forgot password">
    <div class="bg-gray-50 flex min-h-full flex-col justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Forgot your password</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
            <div class="bg-white px-6 py-12 shadow rounded-lg sm:px-12">
                <div class="mb-4 text-sm text-gray-700">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>
                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" autocomplete="email" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        @if (session('status'))
                        <p class="text-sm text-green-600 mt-2">{{ session('status') }}</p>
                        @endif
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{ __('Email Password Reset Link') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-base-layout>