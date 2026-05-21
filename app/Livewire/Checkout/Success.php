<?php

namespace App\Livewire\Checkout;

use App\Models\Order;
use App\Models\Ticket;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Livewire\Component;

class Success extends Component
{
    public ?Order $order = null;
    public int $ticketCount = 0;
    public string $error = '';

    public function mount(Request $request, StripeService $stripeService)
    {
        $sessionId = $request->query('session_id');

        if (! $sessionId) {
            $this->error = 'Geen geldige Stripe sessie gevonden.';
            return;
        }

        try {
            // Retrieve session from Stripe
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $session = \Stripe\Checkout\Session::retrieve($sessionId);

            $orderId = $session->metadata->order_id ?? null;
            $ticketQuantitiesJson = $session->metadata->ticket_quantities ?? '{}';
            $quantities = json_decode($ticketQuantitiesJson, true) ?? [];

            if (! $orderId) {
                $this->error = 'Bestellings-ID ontbreekt in de Stripe payload.';
                return;
            }

            // Find order (bypass global TenantScope since public visitors don't have active_organization_id session)
            $this->order = Order::withoutGlobalScopes()->with('event')->find($orderId);

            if (! $this->order) {
                $this->error = 'Bestelling niet gevonden in onze database.';
                return;
            }

            $totalQuantity = 0;

            // Initial check if order is already paid
            if ($this->order->status === 'paid') {
                $this->ticketCount = $this->order->tickets()->count();
            } else {
                $this->ticketCount = 0;
            }

        } catch (\Exception $e) {
            $this->error = 'Er is een fout opgetreden bij het verifiëren van je betaling: ' . $e->getMessage();
        }
    }

    public function checkStatus()
    {
        // Livewire re-hydrates the order automatically, but just to be sure we refresh it
        if ($this->order) {
            $this->order->refresh();
            if ($this->order->status === 'paid') {
                $this->ticketCount = $this->order->tickets()->count();
            }
        }
    }

    public function render()
    {
        return view('livewire.checkout.success')
            ->layout('components.layouts.public', [
                'title' => 'Betaling geslaagd | GrapATix'
            ]);
    }
}
