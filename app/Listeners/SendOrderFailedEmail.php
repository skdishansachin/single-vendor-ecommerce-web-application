<?php

namespace App\Listeners;

use App\Events\OrderFailed;
use App\Mail\OrderFailedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderFailedEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderFailed $event): void
    {
        Mail::to($event->order->user->email)
            ->send(new OrderFailedMail($event->order));
    }
}
