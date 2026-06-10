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

            // Sync fallback: if Stripe session is paid but order is not marked paid locally, process it immediately.
            // This is a robust fallback for delays in Stripe webhooks/queue processing in local dev environments.
            if ($session->payment_status === 'paid' && $this->order->status !== 'paid') {
                \Illuminate\Support\Facades\DB::transaction(function () use ($session, $quantities) {
                    $order = Order::withoutGlobalScopes()->where('id', $this->order->id)->lockForUpdate()->first();
                    
                    if ($order && $order->status !== 'paid') {
                        $order->update([
                            'status' => 'paid',
                            'payment_id' => $session->payment_intent ?? $session->id,
                        ]);

                        $qrCodeService = app(\App\Services\QrCodeService::class);

                        foreach ($quantities as $ticketTypeId => $qty) {
                            for ($i = 0; $i < $qty; $i++) {
                                $qrData = $qrCodeService->generateForTicket();

                                Ticket::create([
                                    'organization_id' => $order->organization_id,
                                    'event_id' => $order->event_id,
                                    'user_id' => $order->user_id,
                                    'ticket_type_id' => $ticketTypeId,
                                    'order_id' => $order->id,
                                    'qr_code' => $qrData['url'],
                                    'qr_image_path' => $qrData['path'],
                                    'status' => 'paid',
                                ]);
                            }
                        }

                        // Dispatch email job
                        $email = $session->customer_details->email ?? null;
                        $name = $session->customer_details->name ?? null;
                        \App\Jobs\SendTicketEmailJob::dispatch($order->id, $email, $name);
                    }
                });
                
                $this->order->refresh();
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
