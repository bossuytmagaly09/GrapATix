<?php

namespace App\Livewire\Events;

use App\Models\Event;
use App\Models\Order;
use App\Services\StripeService;
use Livewire\Component;

class Show extends Component
{
    public Event $event;
    public int $quantity = 1;

    public function mount(Event $event)
    {
        $this->event = $event->load(['category', 'venue', 'media']);
    }

    public function incrementQuantity()
    {
        if ($this->quantity < 10) {
            $this->quantity++;
        }
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function buyTickets(StripeService $stripeService)
    {
        $totalCents = $this->event->price_cents * $this->quantity;

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
            $this->quantity,
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
