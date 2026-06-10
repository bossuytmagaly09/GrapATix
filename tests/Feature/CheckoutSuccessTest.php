<?php

use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\Order;
use App\Models\Organization;
use Livewire\Livewire;
use App\Livewire\Checkout\Success;

test('it processes order synchronously when Stripe session is paid but order is pending', function () {
    // Enable alias mocking for Stripe Session class before it is loaded in the request lifecycle
    $stripeSessionMock = Mockery::mock('alias:\Stripe\Checkout\Session');

    $organization = Organization::factory()->create();
    $user = User::factory()->create(['organization_id' => $organization->id]);

    $event = Event::factory()->create(['organization_id' => $organization->id]);
    $ticketType = TicketType::create([
        'event_id' => $event->id,
        'organization_id' => $organization->id,
        'name' => 'Regular Entry',
        'price_cents' => 1000,
        'available_quantity' => 100,
        'is_published' => true,
    ]);

    // Create a pending order
    $order = Order::create([
        'organization_id' => $organization->id,
        'user_id' => $user->id,
        'event_id' => $event->id,
        'total_cents' => 2000,
        'status' => 'pending',
    ]);

    // Mock Stripe Checkout Session response
    $stripeSessionMock->shouldReceive('retrieve')
        ->once()
        ->with('cs_test_12345')
        ->andReturn((object)[
            'id' => 'cs_test_12345',
            'payment_status' => 'paid',
            'payment_intent' => 'pi_test_12345',
            'metadata' => (object)[
                'order_id' => $order->id,
                'ticket_quantities' => json_encode([$ticketType->id => 2]),
            ],
            'customer_details' => (object)[
                'email' => 'customer@example.com',
                'name' => 'Test Customer',
            ],
        ]);

    // Verify initial database state: order pending, 0 tickets
    expect($order->status)->toBe('pending');
    expect(Ticket::where('order_id', $order->id)->count())->toBe(0);

    // Call the Success component mount and view
    Livewire::withQueryParams(['session_id' => 'cs_test_12345'])
        ->test(Success::class)
        ->assertSet('ticketCount', 2)
        ->assertHasNoErrors();

    // Verify order is now paid and tickets are created
    $order->refresh();
    expect($order->status)->toBe('paid');
    expect($order->payment_id)->toBe('pi_test_12345');
    expect(Ticket::where('order_id', $order->id)->count())->toBe(2);
});
