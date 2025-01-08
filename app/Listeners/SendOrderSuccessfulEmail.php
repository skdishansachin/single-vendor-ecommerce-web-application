<?php

namespace App\Listeners;

use App\Events\OrderSuccessful;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOrderSuccessfulEmail
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(OrderSuccessful $event): void
    {
        Log::info('Sending order successful email. The order ID is '.$event->order->id);
        Mail::to($event->order->user->email)
            ->send(new \App\Mail\OrderSuccessful($event->order));
    }
}
