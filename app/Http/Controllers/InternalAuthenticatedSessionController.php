<?php

namespace App\Http\Controllers;

use App\Rules\CheckStaff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class InternalAuthenticatedSessionController extends Controller
{
    public function index(): View
    {
        return view('dashboard.auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', new CheckStaff()],
            'password' => ['required', 'string'],
        ]);

        // Attempt to authenticate the user
        if (! Auth::guard('web')->attempt($request->only('email', 'password'), true)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        return to_route('dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('index');
    }
}
