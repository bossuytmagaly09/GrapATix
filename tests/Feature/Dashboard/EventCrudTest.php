<?php

namespace Tests\Feature\Dashboard;

use App\Models\Event;
use App\Models\Category;
use App\Models\Organization;
use App\Models\User;
use App\Livewire\Events\Index as EventsIndex;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated users can see events', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('events.index'))
        ->assertStatus(200);
});

test('events can be created with price conversion', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    
    // We simuleren de middleware door de actieve organisatie van de user in de sessie te plaatsen
    session(['active_organization_id' => $user->organization_id]);

    Livewire::actingAs($user)
        ->test(EventsIndex::class)
        ->set('title', 'Graspop 2026')
        ->set('category_id', $category->id)
        ->set('start_date', now()->addDays(10)->format('Y-m-d\TH:i'))
        ->set('end_date', now()->addDays(11)->format('Y-m-d\TH:i'))
        ->set('price', 150.50)
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('events', [
        'title' => 'Graspop 2026',
        'price_cents' => 15050, // Controleert of de euro naar cent conversie klopt
    ]);
});

test('events validation prevents end date before start date', function () {
    $user = User::factory()->create();
    
    Livewire::actingAs($user)
        ->test(EventsIndex::class)
        ->set('start_date', now()->addDays(10)->format('Y-m-d\TH:i'))
        ->set('end_date', now()->addDays(9)->format('Y-m-d\TH:i')) // Foutieve datum
        ->call('save')
        ->assertHasErrors(['end_date' => 'after']);
});

test('events can be deleted', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $org = Organization::create(['name' => 'Test Org', 'subdomain' => 'test']);
    
    $event = Event::factory()->create([
        'organization_id' => $org->id,
        'category_id' => $category->id
    ]);

    Livewire::actingAs($user)
        ->test(EventsIndex::class)
        ->call('delete', $event->id);

    $this->assertSoftDeleted('events', [
        'id' => $event->id,
    ]);
});
