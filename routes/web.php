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
    // Hier komt later in Fase 4.2 de logica om het ticket te valideren/scannen
    return "Scan endpoint voor ticket. Validatie logica komt hier.";
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
