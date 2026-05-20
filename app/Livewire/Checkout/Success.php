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
            $quantity = (int) ($session->metadata->quantity ?? 1);

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

            // Check if order is already paid to prevent double ticketing
            if ($this->order->status !== 'paid') {
                $this->order->update([
                    'status' => 'paid',
                    'payment_id' => $session->payment_intent ?? $session->id,
                ]);

                // Create tickets
                $defaultTicketType = $this->order->event->getDefaultTicketType();

                for ($i = 0; $i < $quantity; $i++) {
                    Ticket::create([
                        'organization_id' => $this->order->organization_id,
                        'event_id' => $this->order->event_id,
                        'user_id' => $this->order->user_id,
                        'ticket_type_id' => $defaultTicketType->id,
                        'order_id' => $this->order->id,
                        'qr_code' => 'GTX-' . strtoupper(Str::random(12)),
                        'status' => 'paid',
                    ]);
                }
            }

            $this->ticketCount = $quantity;

        } catch (\Exception $e) {
            $this->error = 'Er is een fout opgetreden bij het verifiëren van je betaling: ' . $e->getMessage();
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
