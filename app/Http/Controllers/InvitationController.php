<?php

namespace App\Http\Controllers;

use App\Mail\InvitationSent;
use App\Models\Invitation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Invitation::class);

        $invitations = Invitation::with('sender')->paginate(10);

        return view('dashboard.invitations.index', [
            'invitations' => $invitations,
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', Invitation::class);

        return view('dashboard.invitations.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Invitation::class);

        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:invitations,email', 'unique:users,email'],
            'roles' => ['required', 'array'],
            'roles.*' => ['required', 'string', 'exists:roles,name'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['required', 'string', 'exists:permissions,name'],
        ]);

        $invitation = Invitation::create([
            'sender_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'roles' => $request->roles,
            'permissions' => $request->permissions,
            'token' => md5(random_bytes(10).$request->email), // WARNING - This token is huge!
            'expires_at' => now()->addMinute(15), // Note - Change this for production
        ]);

        $signedUrl = URL::temporarySignedRoute('dashboard.register', $invitation->expires_at, ['token' => $invitation->token]); // Note - Change this for production

        Mail::to($invitation->email)->send(new InvitationSent($invitation, $signedUrl));

        session()->flash('message', "Invitation sent to $invitation->name");

        return to_route('dashboard.invitations.show', $invitation);
    }

    public function show(Invitation $invitation): View
    {
        Gate::authorize('view', $invitation);

        return view('dashboard.invitations.show', [
            'invitation' => $invitation,
        ]);
    }

    public function resend(Invitation $invitation): JsonResponse
    {
        Gate::authorize('view', $invitation);
        Gate::authorize('update', $invitation);

        $invitation->update([
            'expires_at' => now()->addMinute(15),
            'status' => 'pending',
        ]);

        $signedUrl = URL::temporarySignedRoute('dashboard.register', $invitation->expires_at, ['token' => $invitation->token]); // Note - Change this for production

        Mail::to($invitation->email)->send(new InvitationSent($invitation, $signedUrl));

        session()->flash('message', "Invitation resent to $invitation->name.");

        return response()->json(['message' => 'success']);
    }

    public function cancel(Invitation $invitation): JsonResponse
    {
        Gate::authorize('view', $invitation);
        Gate::authorize('update', $invitation);

        $invitation->update([
            'expires_at' => now(),
            'status' => 'cancel',
        ]);

        session()->flash('message', 'Invitation canceled.');

        return response()->json(['message' => 'success']);
    }
}
