@extends('layouts.dashboard')
@section('title', 'user Edit')

@section('content')
<header class="bg-white shadow">
    <div class="max-w-7xl mx-auto py-8">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('User Edit') }}
            </h2>
            <div class="flex items-center gap-5" id="btn-actions">
                @can('add and remove users')
                <button type="button" onclick="document.getElementById('user_edit_form').submit();" class="flex justify-center rounded-md bg-gray-600 px-5 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">{{ __('Edit') }}</button>
                <form action="{{ route('app.users.destroy', $user) }}" method="post">
                    @method('delete')
                    @csrf
                    <button type="submit" class="flex justify-center rounded-md bg-red-500 px-5 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-red-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500">{{ __('Delete') }}</button>
                </form>
                @endcan
                <a href="{{ route('app.users.index') }}" role="button" class="flex justify-center rounded-md bg-blue-600 px-5 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">{{ __('Back') }}</a>
            </div>
        </div>
    </div>
</header>
<div class="max-w-7xl mx-auto py-8">
    <form action="{{ route('app.users.update', $user) }}" method="POST" enctype="multipart/form-data" id="user_edit_form">
        @method('PUT')
        @csrf
        <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-4">
                <div class="bg-white rounded-lg shadow-sm border">
                    <div class="max-w-7xl mx-auto p-6">
                        <div>
                            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                            <div class="mt-2">
                                <input type="text" name="name" id="name" autocomplete="off" value="{{ old('name', $user->name) }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>

                            @error('name')
                            <div class="text-sm text-red-600 mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-sm border mt-8">
                    <div class="max-w-7xl mx-auto p-6">
                        <div class="px-4 sm:px-0">
                            <h1 class="text-base font-semibold leading-7 text-gray-900">Permissions</h1>
                        </div>
                        <div class="mt-3 border-t border-gray-100">
                            <div class="my-3">
                                @foreach($roles as $role)
                                <div class="py-3 space-y-3">
                                    <div class="flex">
                                        <input type="checkbox" class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" id="{{ $role->name }}" name="roles[]" value="{{ $role->name }}" @checked(in_array($role->name, old('roles', $user->getRoleNames()->toArray()))) />
                                        <label for="{{ $role->name }}" class="text-sm text-gray-500 ms-3 capitalize">{{ $role->name }} management</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @error('roles')
                            <div class="text-sm text-red-600 mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="sm:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border">
                    <div class="max-w-7xl mx-auto p-6">

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection