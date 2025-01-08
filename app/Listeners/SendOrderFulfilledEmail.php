<?php

namespace App\Listeners;

use App\Events\OrderFulfilled;
use App\Mail\OrderFulfilledMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendOrderFulfilledEmail implements ShouldQueue
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
    public function handle(OrderFulfilled $event): void
    {
        Mail::to($event->order->user->email)->send(new OrderFulfilledMail($event->order));
    }
}
