<?php

use App\Models\User;
use App\Models\Event;
use App\Models\Category;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a user can only see events from their own organization', function () {
    // 1. Setup: Maak twee organisaties
    $orgA = Organization::factory()->create(['name' => 'Org A']);
    $orgB = Organization::factory()->create(['name' => 'Org B']);

    // 2. Setup: Maak een user voor Org A
    $userA = User::factory()->create(['organization_id' => $orgA->id]);

    // 3. Setup: Maak events voor beide
    $eventA = Event::factory()->create(['organization_id' => $orgA->id, 'title' => 'Event van Org A']);
    $eventB = Event::factory()->create(['organization_id' => $orgB->id, 'title' => 'Event van Org B']);

    // 4. Act: Log in als User A en haal alle events op
    $this->actingAs($userA);
    
    // We simuleren de middleware door de sessie te zetten
    session(['active_organization_id' => $orgA->id]);

    $events = Event::all();

    // 5. Assert: We mogen alleen Event A zien
    expect($events)->toHaveCount(1);
    expect($events->first()->id)->toBe($eventA->id);
    expect($events->first()->title)->toBe('Event van Org A');
});

test('a user cannot see categories from another organization', function () {
    $orgA = Organization::factory()->create();
    $orgB = Organization::factory()->create();

    $userA = User::factory()->create(['organization_id' => $orgA->id]);
    
    Category::factory()->create(['organization_id' => $orgA->id, 'name' => 'Cat A']);
    Category::factory()->create(['organization_id' => $orgB->id, 'name' => 'Cat B']);

    $this->actingAs($userA);
    session(['active_organization_id' => $orgA->id]);

    $categories = Category::all();

    expect($categories)->toHaveCount(1);
    expect($categories->first()->name)->toBe('Cat A');
});

test('a user cannot update an event from another organization', function () {
    $orgA = Organization::factory()->create();
    $orgB = Organization::factory()->create();

    $userA = User::factory()->create(['organization_id' => $orgA->id]);
    $eventB = Event::factory()->create(['organization_id' => $orgB->id]);

    $this->actingAs($userA);
    session(['active_organization_id' => $orgA->id]);

    // Omdat de Global Scope aanstaat, zal Event::find($eventB->id) NULL teruggeven
    $foundEvent = Event::find($eventB->id);
    
    expect($foundEvent)->toBeNull();
});

test('newly created models are automatically linked to the active tenant', function () {
    $orgA = Organization::factory()->create();
    $userA = User::factory()->create(['organization_id' => $orgA->id]);

    $this->actingAs($userA);
    session(['active_organization_id' => $orgA->id]);

    // We maken een event aan ZONDER expliciet de organization_id mee te geven
    $newEvent = Event::create([
        'title' => 'Automatisch Gekoppeld Event',
        'uuid' => (string) \Illuminate\Support\Str::uuid(),
        'slug' => 'auto-event',
        'start_date' => now(),
    ]);

    expect($newEvent->organization_id)->toBe($orgA->id);
});
