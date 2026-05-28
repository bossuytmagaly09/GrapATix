<?php

use App\Http\Middleware\EnsureTeamMembership;
use App\Livewire\Categories\Index as CategoriesIndex;
use App\Livewire\Events\Index as EventsIndex;
use App\Livewire\Home;
use App\Livewire\Events\Show as EventsShow;
use App\Livewire\Categories\Show as CategoriesShow;
use App\Livewire\Auth as AuthComponent;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', Home::class)->name('home');
Route::get('/events/{event:slug}', EventsShow::class)->name('events.show');
Route::get('/categories/{category:slug}', CategoriesShow::class)->name('categories.show');
Route::get('/checkout/success', \App\Livewire\Checkout\Success::class)->name('checkout.success');

Route::post('/stripe/webhook', [\App\Http\Controllers\StripeWebhookController::class, 'handle'])->name('stripe.webhook');

Route::get('/tickets/scan/{token}', function ($token) {
    // Vind het ticket via de token in de qr_code URL
    $ticket = \App\Models\Ticket::withoutGlobalScopes()
        ->with(['ticketType', 'event.venue', 'user', 'scannedBy'])
        ->where('qr_code', 'like', '%' . $token . '%')
        ->first();

    if (!$ticket) {
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'status' => 'error',
                'error_type' => 'not_found',
                'message' => 'Ticket niet gevonden in de database.'
            ], 404);
        }
        abort(404, 'Ticket niet gevonden.');
    }

    $event = $ticket->event;

    // Check of we scannen voor een specifiek evenement via de HTTP header
    $scannerEventId = request()->header('X-Scanner-Event-Id');
    if ($scannerEventId && $ticket->event_id != $scannerEventId) {
        $scannerEvent = \App\Models\Event::withoutGlobalScopes()->find($scannerEventId);
        $message = sprintf(
            'Dit ticket is voor het verkeerde evenement! Bestemd voor: "%s", maar je scant momenteel voor: "%s".',
            $event->title ?? 'ander evenement',
            $scannerEvent?->title ?? 'een ander evenement'
        );
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'status' => 'error',
                'error_type' => 'wrong_event',
                'message' => $message,
                'ticket_type' => $ticket->ticketType->name ?? 'Standaard',
                'event_title' => $event->title ?? 'Evenement',
            ], 422);
        }
        return view('tickets.scan_result', [
            'status' => 'error',
            'message' => $message,
            'ticket' => $ticket
        ]);
    }

    // Check of het ticket al gescand is
    if ($ticket->scanned_at) {
        $scannedTime = $ticket->scanned_at->timezone('Europe/Brussels')->format('H:i:s (d M Y)');
        $scannedByName = $ticket->scannedBy?->name ?? 'onbekende portier';
        $message = "Dit ticket is AL GEBRUIKT! Gescand om {$scannedTime} door {$scannedByName}.";

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'status' => 'already_scanned',
                'message' => $message,
                'scanned_at' => $ticket->scanned_at->toIso8601String(),
                'scanned_by' => $scannedByName,
                'ticket_type' => $ticket->ticketType->name ?? 'Standaard',
                'customer_name' => $ticket->user->name ?? 'Gast/Klant',
            ], 200);
        }

        return view('tickets.scan_result', [
            'status' => 'warning',
            'message' => $message,
            'ticket' => $ticket
        ]);
    }

    // Valideer het ticket en markeer als gescand!
    $ticket->update([
        'status' => 'scanned',
        'scanned_at' => now(),
        'scanned_by' => auth()->id() ?? null
    ]);

    $customerName = $ticket->user->name ?? 'Gast/Klant';
    $message = "Geldig ticket! Welkom, {$customerName}.";

    if (request()->wantsJson() || request()->ajax()) {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'ticket_type' => $ticket->ticketType->name ?? 'Standaard',
            'customer_name' => $customerName,
            'scanned_at' => $ticket->scanned_at->toIso8601String(),
        ]);
    }

    return view('tickets.scan_result', [
        'status' => 'success',
        'message' => $message,
        'ticket' => $ticket
    ]);
})->name('tickets.scan')->middleware('signed');

Route::get('/tickets/{ticket}', [\App\Http\Controllers\TicketController::class, 'show'])
    ->name('tickets.show');

// Auth Routes
Route::get('/login', AuthComponent::class)->name('login');
Route::get('/register', AuthComponent::class)->name('register');

// Dashboard Routes (Tenant-aware)
Route::prefix('dashboard')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/', \App\Livewire\Dashboard\Index::class)->name('dashboard');
        Route::get('/categories', CategoriesIndex::class)->name('categories.index');
        Route::get('/events', EventsIndex::class)->name('events.index');
        Route::get('/events/{event}/tickets', \App\Livewire\Events\TicketTypes::class)->name('events.tickets');
        Route::get('/events/{event}/scanner', \App\Livewire\Dashboard\Scanner::class)->name('events.scanner');
        Route::get('/orders', \App\Livewire\Dashboard\Orders::class)->name('orders.index');
        Route::get('/settings', \App\Livewire\Dashboard\TenantSettings::class)->name('tenant.settings');
        
        // Master Admin Routes (Platform Beheer)
        Route::middleware(['can:access-master-dashboard'])
            ->prefix('master')
            ->group(function () {
                Route::get('/', \App\Livewire\Dashboard\Master\Index::class)->name('dashboard.master');
                Route::get('/organizations', \App\Livewire\Dashboard\Master\Organizations::class)->name('dashboard.master.organizations');
                Route::get('/users', \App\Livewire\Dashboard\Master\Users::class)->name('dashboard.master.users');
                Route::get('/orders', \App\Livewire\Dashboard\Master\Orders::class)->name('dashboard.master.orders');
                Route::get('/finances', \App\Livewire\Dashboard\Master\Finances::class)->name('dashboard.master.finances');
                Route::get('/settings', \App\Livewire\Dashboard\Master\Settings::class)->name('dashboard.master.settings');
            });
    });

Route::middleware(['auth'])->group(function () {
    Route::livewire('invitations/{invitation}/accept', 'pages::teams.accept-invitation')->name('invitations.accept');
});

require __DIR__.'/settings.php';
