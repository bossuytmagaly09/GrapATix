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

// Auth Routes
Route::get('/login', AuthComponent::class)->name('login');
Route::get('/register', AuthComponent::class)->name('register');

// Dashboard Routes (Tenant-aware)
Route::prefix('dashboard')
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::view('/', 'dashboard')->name('dashboard');
        Route::get('/categories', CategoriesIndex::class)->name('categories.index');
        Route::get('/events', EventsIndex::class)->name('events.index');
        Route::get('/orders', \App\Livewire\Dashboard\Orders::class)->name('orders.index');
        
        // Master Admin Routes (Platform Beheer)
        Route::middleware(['can:access-master-dashboard'])
            ->prefix('master')
            ->group(function () {
                Route::get('/', \App\Livewire\Dashboard\Master\Index::class)->name('dashboard.master');
            });
    });

Route::middleware(['auth'])->group(function () {
    Route::livewire('invitations/{invitation}/accept', 'pages::teams.accept-invitation')->name('invitations.accept');
});

require __DIR__.'/settings.php';
