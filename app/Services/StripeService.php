<?php

namespace App\Services;

use App\Models\Order;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create a Stripe Checkout Session for a pending Order.
     *
     * @param Order $order
     * @param array $lineItems
     * @param array $quantities
     * @param string $successUrl
     * @param string $cancelUrl
     * @return Session
     */
    public function createCheckoutSession(Order $order, array $lineItems, array $quantities, string $successUrl, string $cancelUrl): Session
    {
        return Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => $successUrl . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $cancelUrl,
            'metadata' => [
                'order_id' => $order->id,
                'ticket_quantities' => json_encode($quantities),
            ],
        ]);
    }
}
