<?php

use App\Http\Middleware\EnsureTeamMembership;
use App\Livewire\Categories\Index as CategoriesIndex;
use App\Livewire\Events\Index as EventsIndex;
use App\Livewire\Home;
use App\Livewire\Events\Show as EventsShow;
use App\Livewire\Categories\Show as CategoriesShow;
use App\Livewire\Auth as AuthComponent;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/events/{event:slug}', EventsShow::class)->name('events.show');
Route::get('/categories/{category:slug}', CategoriesShow::class)->name('categories.show');

Route::get('/login', AuthComponent::class)->name('login');
Route::get('/register', AuthComponent::class)->name('register');

Route::prefix('{current_team}')
    ->middleware(['auth', 'verified', EnsureTeamMembership::class])
    ->group(function () {
        Route::view('dashboard', 'dashboard')->name('dashboard');
    });

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('categories', CategoriesIndex::class)->name('categories.index');
    Route::get('events', EventsIndex::class)->name('events.index');
});

Route::middleware(['auth'])->group(function () {
    Route::livewire('invitations/{invitation}/accept', 'pages::teams.accept-invitation')->name('invitations.accept');
});

require __DIR__.'/settings.php';
