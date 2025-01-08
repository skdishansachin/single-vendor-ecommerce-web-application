<?php

namespace App\Enums;

enum FulfillmentStatus: string
{
    case Unfulfilled = 'unfulfilled';
    case Fulfilled = 'fulfilled';
    case Cancelled = 'cancelled';
    case Returned = 'returned';
    case Refunded = 'refunded';
}
