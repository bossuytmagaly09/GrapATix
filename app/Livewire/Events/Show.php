<?php

namespace App\Livewire\Events;

use App\Models\Event;
use App\Models\Order;
use App\Services\StripeService;
use Livewire\Component;

class Show extends Component
{
    public Event $event;
    public array $quantities = [];
    public $ticketTypes = [];

    public function mount(Event $event)
    {
        $this->event = $event->load(['category', 'venue', 'media']);
        $this->ticketTypes = $this->event->ticketTypes()
            ->where('is_published', true)
            ->withCount('tickets') // So we can calculate available tickets minus sold tickets
            ->orderBy('price_cents')
            ->get();
        
        foreach ($this->ticketTypes as $type) {
            $this->quantities[$type->id] = 0;
        }
    }

    public function incrementQuantity($id)
    {
        $type = $this->ticketTypes->firstWhere('id', $id);
        if (!$type) return;

        $remaining = max(0, $type->available_quantity - $type->tickets_count);
        $current = $this->quantities[$id] ?? 0;

        // Limit to 10 per order AND limit to remaining stock
        if ($current < 10 && $current < $remaining) {
            $this->quantities[$id]++;
        }
    }

    public function decrementQuantity($id)
    {
        if (isset($this->quantities[$id]) && $this->quantities[$id] > 0) {
            $this->quantities[$id]--;
        }
    }

    public function buyTickets(StripeService $stripeService)
    {
        $totalCents = 0;
        $totalTickets = 0;
        $lineItems = [];
        $validQuantities = [];

        foreach ($this->ticketTypes as $type) {
            $qty = $this->quantities[$type->id] ?? 0;
            $remaining = max(0, $type->available_quantity - $type->tickets_count);
            
            if ($qty > $remaining) {
                \Flux::toast("Er zijn nog maar {$remaining} tickets over voor {$type->name}.", 'error');
                return;
            }
            if ($qty > 0) {
                $totalCents += $type->price_cents * $qty;
                $totalTickets += $qty;
                $validQuantities[$type->id] = $qty;
                
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $type->name . ' - ' . $this->event->title,
                            'description' => 'Toegangsticket voor ' . $this->event->title,
                        ],
                        'unit_amount' => $type->price_cents,
                    ],
                    'quantity' => $qty,
                ];
            }
        }

        if ($totalTickets === 0) {
            \Flux::toast('Selecteer minstens één ticket om verder te gaan.', 'error');
            return;
        }

        // Create a pending Order
        $order = Order::create([
            'organization_id' => $this->event->organization_id,
            'user_id' => auth()->id(), // null if guest/visitor
            'event_id' => $this->event->id,
            'total_cents' => $totalCents,
            'status' => 'pending',
        ]);

        $successUrl = route('checkout.success');
        $cancelUrl = route('events.show', $this->event->slug);

        // Create Stripe checkout session
        $session = $stripeService->createCheckoutSession(
            $order,
            $lineItems,
            $validQuantities,
            $successUrl,
            $cancelUrl
        );

        // Redirect to Stripe Checkout
        return $this->redirect($session->url, navigate: false);
    }

    public function render()
    {
        return view('livewire.events.show')
            ->layout('components.layouts.public', [
                'title' => $this->event->title . ' | GrapATix'
            ]);
    }
}
