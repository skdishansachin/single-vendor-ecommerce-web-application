<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

use function Laravel\Prompts\password;
use function Laravel\Prompts\pause;
use function Laravel\Prompts\text;

Artisan::command('user:create', function () {
    $name = text(
        label: 'What is your name?',
        placeholder: 'E.g. John Doe',
        hint: 'This will be displayed on your profile.',
        required: 'Your name is required.',
    );

    $email = text(
        label: 'What is your email?',
        placeholder: 'E.g. johndoe@ex.com',
        hint: 'This will be used to log in.',
        validate: ['required', 'email', 'unique:users,email'],
        required: 'Your email is required.',
    );

    $password = password(
        label: 'What is your password?',
        hint: 'This will be used to log in.',
        validate: ['required', Password::default()],
        required: 'Your password is required.',
    );

    pause('Are you sure! Press ENTER to continue.');

    $user = User::create([
        'name' => $name,
        'email' => $email,
        'password' => Hash::make($password),
    ]);
    $user->assignRole('admin');

})->purpose('Create a user');
