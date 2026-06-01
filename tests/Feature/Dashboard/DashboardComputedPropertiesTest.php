<?php

use App\Models\User;
use App\Models\Organization;
use App\Models\Event;
use App\Models\TicketType;
use App\Models\Ticket;
use App\Models\Order;
use App\Models\ScanLog;
use Livewire\Livewire;
use App\Livewire\Dashboard\Index as TenantDashboard;
use App\Livewire\Dashboard\Master\Index as MasterDashboard;

beforeEach(function () {
    // 1. Create a tenant and a user belonging to it
    $this->org = Organization::create([
        'name' => 'Tomorrowland Test',
        'subdomain' => 'tomorrowland-test',
    ]);

    $this->user = User::factory()->create([
        'organization_id' => $this->org->id,
    ]);

    // 2. Create another tenant to test isolation
    $this->otherOrg = Organization::create([
        'name' => 'Other Org Test',
        'subdomain' => 'other-test',
    ]);

    $this->otherUser = User::factory()->create([
        'organization_id' => $this->otherOrg->id,
    ]);

    // 3. Create events
    $this->event = Event::factory()->create([
        'organization_id' => $this->org->id,
        'title' => 'TML Test Event',
        'start_date' => now()->addDays(5),
    ]);

    $this->otherEvent = Event::factory()->create([
        'organization_id' => $this->otherOrg->id,
        'title' => 'Other Event',
        'start_date' => now()->addDays(2),
    ]);

    // 4. Create ticket types
    $this->ticketType = TicketType::create([
        'event_id' => $this->event->id,
        'name' => 'TML Regular',
        'price_cents' => 10000,
        'available_quantity' => 100,
        'is_published' => true,
    ]);

    $this->otherTicketType = TicketType::create([
        'event_id' => $this->otherEvent->id,
        'name' => 'Other Regular',
        'price_cents' => 5000,
        'available_quantity' => 50,
        'is_published' => true,
    ]);
});

test('tenant dashboard computed properties calculate correctly and isolates data', function () {
    // Make sure we are in the session of the active organization
    session(['active_organization_id' => $this->org->id]);

    // Create orders and tickets for active tenant
    $order1 = Order::create([
        'organization_id' => $this->org->id,
        'user_id' => $this->user->id,
        'event_id' => $this->event->id,
        'total_cents' => 20000, // 2 tickets
        'status' => 'paid',
        'created_at' => now(), // within this week
    ]);

    $ticket1 = Ticket::create([
        'organization_id' => $this->org->id,
        'event_id' => $this->event->id,
        'user_id' => $this->user->id,
        'ticket_type_id' => $this->ticketType->id,
        'order_id' => $order1->id,
        'qr_code' => 'test-qr-1',
        'status' => 'paid',
    ]);

    $ticket2 = Ticket::create([
        'organization_id' => $this->org->id,
        'event_id' => $this->event->id,
        'user_id' => $this->user->id,
        'ticket_type_id' => $this->ticketType->id,
        'order_id' => $order1->id,
        'qr_code' => 'test-qr-2',
        'status' => 'scanned',
    ]);

    // Create a scan log for ticket2
    ScanLog::create([
        'ticket_id' => $ticket2->id,
        'scanned_by' => $this->user->id,
        'scanned_at' => now(),
        'status' => 'success',
    ]);

    // Create a duplicate scan log
    ScanLog::create([
        'ticket_id' => $ticket2->id,
        'scanned_by' => $this->user->id,
        'scanned_at' => now(),
        'status' => 'duplicate',
    ]);

    // Create an order for the OTHER tenant to test isolation
    $otherOrder = Order::create([
        'organization_id' => $this->otherOrg->id,
        'user_id' => $this->otherUser->id,
        'event_id' => $this->otherEvent->id,
        'total_cents' => 15000,
        'status' => 'paid',
        'created_at' => now(),
    ]);

    $otherTicket = Ticket::create([
        'organization_id' => $this->otherOrg->id,
        'event_id' => $this->otherEvent->id,
        'user_id' => $this->otherUser->id,
        'ticket_type_id' => $this->otherTicketType->id,
        'order_id' => $otherOrder->id,
        'qr_code' => 'test-qr-other',
        'status' => 'paid',
    ]);

    // Test Livewire component
    Livewire::actingAs($this->user)
        ->test(TenantDashboard::class)
        ->assertOk()
        ->tap(function ($component) {
            $instance = $component->instance();
            
            // Check basic stats
            expect($instance->totalRevenue)->toEqual(200); // 20000 cents
            expect($instance->totalTicketsSold)->toBe(2);  // $ticket1 + $ticket2
            expect($instance->activeEventsCount)->toBe(1); // $this->event
            
            // Check weekly revenue
            expect($instance->revenueThisWeek)->toEqual(200);
            
            // Check scan stats
            $scanStats = $instance->scanStats;
            expect($scanStats['total'])->toBe(2);
            expect($scanStats['success'])->toBe(1);
            expect($scanStats['duplicate'])->toBe(1);
            expect($scanStats['invalid'])->toBe(0);
            expect($scanStats['success_rate'])->toBe(50.0);

            // Check sold per event
            $soldPerEvent = $instance->ticketsSoldPerEvent;
            expect($soldPerEvent)->toHaveCount(1);
            expect($soldPerEvent->first()->title)->toBe('TML Test Event');
            expect($soldPerEvent->first()->tickets_count)->toBe(2);
            expect($soldPerEvent->first()->total_capacity)->toBe(100);
            expect($soldPerEvent->first()->fill_percentage)->toBe(2.0);
        });
});

test('master dashboard computed properties return global stats', function () {
    // Create paid orders across both organizations
    Order::create([
        'organization_id' => $this->org->id,
        'event_id' => $this->event->id,
        'total_cents' => 30000,
        'status' => 'paid',
    ]);

    Order::create([
        'organization_id' => $this->otherOrg->id,
        'event_id' => $this->otherEvent->id,
        'total_cents' => 20000,
        'status' => 'paid',
    ]);

    // Create tickets and scan logs
    $t1 = Ticket::create([
        'organization_id' => $this->org->id,
        'event_id' => $this->event->id,
        'ticket_type_id' => $this->ticketType->id,
        'qr_code' => 'test-qr-global-1',
        'status' => 'scanned',
    ]);
    
    $t2 = Ticket::create([
        'organization_id' => $this->otherOrg->id,
        'event_id' => $this->otherEvent->id,
        'ticket_type_id' => $this->otherTicketType->id,
        'qr_code' => 'test-qr-global-2',
        'status' => 'scanned',
    ]);

    ScanLog::create([
        'ticket_id' => $t1->id,
        'scanned_at' => now(),
        'status' => 'success',
    ]);

    ScanLog::create([
        'ticket_id' => $t2->id,
        'scanned_at' => now(),
        'status' => 'invalid',
    ]);

    // Visit master dashboard
    Livewire::actingAs($this->user)
        ->test(MasterDashboard::class)
        ->assertOk()
        ->tap(function ($component) {
            $instance = $component->instance();
            
            // Check global scan stats
            $globalStats = $instance->globalScanStats;
            expect($globalStats['total'])->toBe(2);
            expect($globalStats['success'])->toBe(1);
            expect($globalStats['invalid'])->toBe(1);
            expect($globalStats['success_rate'])->toBe(50.0);

            // Check leaderboard (topPerformingOrganizations)
            $leaderboard = $instance->topPerformingOrganizations->values();
            expect($leaderboard[0]->revenue)->toEqual(300);
            expect($leaderboard[1]->revenue)->toEqual(200);
        });
});
