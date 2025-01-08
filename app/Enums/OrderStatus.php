<?php

namespace App\Enums;

/**
 * Represents the status of an order.
 */
enum OrderStatus: string
{
    case Cart = 'cart';
    case Paid = 'paid';
    case Unpaid = 'unpaid';
}
