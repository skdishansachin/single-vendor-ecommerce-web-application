<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Cart = 'cart';
    case Paid = 'paid';
    case Unpaid = 'unpaid';
}
