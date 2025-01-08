<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $user = $request->user();

        $notifications = $user->notifications()->paginate(10);

        return view('dashboard.notifications', [
            'notifications' => $notifications,
        ]);
    }
}
