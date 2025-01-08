@extends('layouts.base')
@section('title', 'Confirm Password')

@section('content')
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
        <div class="p-12 rounded-md bg-white drop-shadow">
            <h2 class="mb-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Confirm your password</h2>
            <form class="space-y-3" action="#" method="POST">
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 disabled:text-gray-200 disabled:border-gray-500 disabled:bg-gray-50 disabled:cursor-not-allowed">
                    </div>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 disabled:text-gray-200 disabled:border-gray-500 disabled:bg-gray-50 disabled:cursor-not-allowed">
                    </div>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6 disabled:text-gray-200 disabled:border-gray-500 disabled:bg-gray-50 disabled:cursor-not-allowed">
                    </div>
                </div>
                <div class="pt-3">
                    <button type="submit" class="flex w-full justify-center rounded-md bg-blue-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Sign in</button>
                </div>
            </form>
        </div>
    </div>
    <p class="mt-10 text-center text-sm text-gray-500">
        Don't have an account?
        <a href="#" class="font-semibold leading-6 text-blue-600 hover:text-blue-500">
            Sign up here
        </a>
    </p>
</div>
@endsection