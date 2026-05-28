<?php

use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\Order;
use App\Models\User;
use App\Models\ScanLog;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

beforeEach(function () {
    // Setup basic models for testing
    $this->user = User::factory()->create();
    
    $this->event = Event::factory()->create([
        'title' => 'Test Festival 2026',
        'price_cents' => 1500,
    ]);

    $this->ticketType = TicketType::create([
        'event_id' => $this->event->id,
        'name' => 'Regular Entry',
        'price_cents' => 1500,
        'available_quantity' => 100,
        'is_published' => true,
    ]);

    $this->order = Order::create([
        'organization_id' => $this->event->organization_id,
        'user_id' => $this->user->id,
        'event_id' => $this->event->id,
        'total_cents' => 1500,
        'status' => 'paid',
    ]);

    $this->token = (string) Str::uuid();
    $this->signedUrl = URL::signedRoute('tickets.scan', ['token' => $this->token]);

    $this->ticket = Ticket::create([
        'organization_id' => $this->event->organization_id,
        'event_id' => $this->event->id,
        'user_id' => $this->user->id,
        'ticket_type_id' => $this->ticketType->id,
        'order_id' => $this->order->id,
        'qr_code' => $this->signedUrl,
        'status' => 'paid',
    ]);
});

test('unsigned scan request is rejected with 403', function () {
    $unsignedUrl = route('tickets.scan', ['token' => $this->token]);
    
    $response = $this->getJson($unsignedUrl);
    
    $response->assertStatus(403);
    expect(Ticket::find($this->ticket->id)->status)->toBe('paid');
    expect(ScanLog::count())->toBe(0);
});

test('valid signed scan request marks ticket as scanned and logs success', function () {
    $response = $this->getJson($this->signedUrl);
    
    $response->assertStatus(200);
    $response->assertJsonFragment([
        'status' => 'success',
        'ticket_type' => 'Regular Entry',
        'customer_name' => $this->user->name,
    ]);

    $ticket = Ticket::find($this->ticket->id);
    expect($ticket->status)->toBe('scanned');
    expect($ticket->scanned_at)->not->toBeNull();

    // Verify ScanLog
    expect(ScanLog::count())->toBe(1);
    $log = ScanLog::first();
    expect($log->ticket_id)->toBe($this->ticket->id);
    expect($log->status)->toBe('success');
    expect($log->scanned_at)->not->toBeNull();
});

test('scanning an already scanned ticket returns duplicate state and logs duplicate', function () {
    // 1. Mark as scanned first
    $this->ticket->update([
        'status' => 'scanned',
        'scanned_at' => now()->subMinutes(10),
    ]);

    // 2. Scan again
    $response = $this->getJson($this->signedUrl);
    
    $response->assertStatus(200);
    $response->assertJsonFragment([
        'status' => 'already_scanned',
    ]);

    // Verify a duplicate scan log is created
    expect(ScanLog::count())->toBe(1);
    $log = ScanLog::first();
    expect($log->ticket_id)->toBe($this->ticket->id);
    expect($log->status)->toBe('duplicate');
});

test('scanning a ticket for the wrong event returns wrong event error and logs invalid', function () {
    // Create another event
    $anotherEvent = Event::factory()->create();
    
    // Scan passing a custom header for the active event scanner
    $response = $this->withHeaders([
        'X-Scanner-Event-Id' => $anotherEvent->id
    ])->getJson($this->signedUrl);
    
    $response->assertStatus(422);
    $response->assertJsonFragment([
        'status' => 'error',
        'error_type' => 'wrong_event',
    ]);

    // Verify ticket is NOT scanned
    $ticket = Ticket::find($this->ticket->id);
    expect($ticket->status)->toBe('paid');
    expect($ticket->scanned_at)->toBeNull();

    // Verify an invalid scan log is created
    expect(ScanLog::count())->toBe(1);
    $log = ScanLog::first();
    expect($log->ticket_id)->toBe($this->ticket->id);
    expect($log->status)->toBe('invalid');
});
