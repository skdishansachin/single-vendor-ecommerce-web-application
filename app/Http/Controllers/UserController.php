<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', User::class);

        $tab = $request->input('tab', 'customers');

        $users = User::query()
            ->when(Str::is($tab, 'customers'), function (Builder $query) {
                $query
                    ->whereNull('banned_at')
                    ->whereHas('roles', function (Builder $query) {
                        $query->where('name', 'customer');
                    });
            })
            ->when(Str::is($tab, 'members'), function (Builder $query) {
                $query
                    ->whereNull('banned_at')
                    ->whereHas('roles', function (Builder $query) {
                        $query->whereIn('name', ['user', 'product', 'order', 'collection', 'admin']);
                    });
            })
            ->when(Str::is($tab, 'banned'), function (Builder $query) {
                $query->whereNotNull('banned_at');
            })
            ->paginate(10);

        return view('dashboard.users.index', [
            'users' => $users,
            'tab' => $tab,
        ]);
    }

    public function show(Request $request, User $user): View
    {
        Gate::authorize('view', $user);

        $user->load('roles');

        $lastOrder = $user->orders()->latest('created_at')->first();

        $canBanUser = ! $user->hasRole('admin') &&
            Auth::id() !== $user->id &&
            $request->user()->can('update users access');

        return view('dashboard.users.show', [
            'user' => $user,
            'lastOrder' => $lastOrder,
            'canBanUser' => $canBanUser,
        ]);
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize('updateAccess', $user);

        if ($user->banned()) {
            $user->update([
                'banned_at' => null,
            ]);
            session()->flash('message', 'User unband successfuly');
        } else {
            $user->update([
                'banned_at' => now(),
            ]);
            session()->flash('message', 'User banned successfuly');
        }

        return response()->json([
            'message' => 'success',
        ]);
    }
}
