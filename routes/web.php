<?php

use App\Http\Middleware\EnsureTeamMembership;
use App\Livewire\Categories\Index as CategoriesIndex;
use App\Livewire\Events\Index as EventsIndex;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::view('/', 'welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

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
