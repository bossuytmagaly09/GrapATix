<?php

use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\Organization;
use Livewire\Livewire;
use App\Livewire\MyTickets;

test('guests are redirected to login from my-tickets', function () {
    $response = $this->get(route('my-tickets'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit my-tickets and see their own tickets', function () {
    $organization = Organization::factory()->create();
    $user = User::factory()->create(['organization_id' => $organization->id]);
    $otherUser = User::factory()->create(['organization_id' => $organization->id]);

    $event = Event::factory()->create(['organization_id' => $organization->id]);
    $ticketType = TicketType::create([
        'event_id' => $event->id,
        'organization_id' => $organization->id,
        'name' => 'Regular Entry',
        'price_cents' => 1000,
        'available_quantity' => 100,
        'is_published' => true,
    ]);

    // Create a ticket for the user
    $ticket = Ticket::create([
        'user_id' => $user->id,
        'event_id' => $event->id,
        'ticket_type_id' => $ticketType->id,
        'organization_id' => $organization->id,
        'status' => 'paid',
        'qr_code' => 'test-qr-user',
    ]);

    // Create a ticket for another user
    $otherTicket = Ticket::create([
        'user_id' => $otherUser->id,
        'event_id' => $event->id,
        'ticket_type_id' => $ticketType->id,
        'organization_id' => $organization->id,
        'status' => 'paid',
        'qr_code' => 'test-qr-other',
    ]);

    // Act as user and visit the route
    $response = $this->actingAs($user)->get(route('my-tickets'));
    $response->assertOk();

    // Verify using Livewire test that only the logged-in user's ticket is shown
    Livewire::actingAs($user)
        ->test(MyTickets::class)
        ->assertSee($event->title)
        ->assertSee($ticketType->name)
        ->assertViewHas('tickets', function ($tickets) use ($ticket, $otherTicket) {
            return $tickets->contains($ticket) && !$tickets->contains($otherTicket);
        });
});
