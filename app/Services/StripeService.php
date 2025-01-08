<?php

namespace App\Services;

use Stripe\StripeClient;

class StripeService
{
    protected StripeClient $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    public function checkout(): void
    {
        // Code
    }

    public function allowPromotionCodes(): void
    {
        // Code
    }

    public function checkoutCharge(): void
    {
        // Code (single product)
    }
}
