<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class InternalRegisterNewUserController extends Controller
{
    public function index(Request $request, string $token)
    {
        if (! $request->hasValidSignature()) {
            abort(401, 'Invitation expired or already used!');
        }

        $invitation = Invitation::where('token', $token)
            ->where('status', 'pending')
            ->firstOrFail();

        if (! $invitation->valid()) {
            abort(401, 'Invitation expired or already used!');
        }

        return view('dashboard.auth.register', [
            'invitation' => $invitation,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'token' => ['required', 'exists:invitations,token'],
        ]);

        $invitation = Invitation::where('token', $request->token)
            ->where('status', 'pending')
            ->firstOrFail();

        if (! $invitation->valid()) {
            abort(401, 'Invitation expired or already used!');
        }

        DB::transaction(function () use ($request, $invitation) {

            $user = User::create([
                'name' => $request->name,
                'email' => $invitation->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole($invitation->roles);
            $user->syncPermissions($invitation->permissions);

            $invitation->update([
                'expires_at' => now(),
                'status' => 'accepted',
            ]);

            Auth::login($user);
        });

        return redirect()->route('dashboard');
    }
}
