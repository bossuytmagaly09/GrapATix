<?php

use App\Models\Category;
use App\Models\Event;
use Livewire\Livewire;
use App\Livewire\Home;

test('homepage renders successfully', function () {
    $this->get('/')
        ->assertStatus(200)
        ->assertSee('GrapATix');
});

test('homepage displays active and published events', function () {
    $category = Category::factory()->create(['name' => 'Festivals', 'slug' => 'festivals']);
    $event = Event::factory()->create([
        'title' => 'Tomorrowland 2026',
        'slug' => 'tomorrowland-2026',
        'category_id' => $category->id,
        'start_date' => now()->addDays(30),
        'is_published' => true,
    ]);

    Livewire::test(Home::class)
        ->assertSee('Tomorrowland 2026')
        ->assertSee('Festivals');
});

test('homepage filtering by category works', function () {
    $catFestivals = Category::factory()->create(['name' => 'Festivals', 'slug' => 'festivals']);
    $catSport = Category::factory()->create(['name' => 'Sport', 'slug' => 'sport']);

    $festivalEvent = Event::factory()->create([
        'title' => 'Summer Festival 2026',
        'category_id' => $catFestivals->id,
        'start_date' => now()->addDays(30),
        'is_published' => true,
    ]);

    $sportEvent = Event::factory()->create([
        'title' => 'Formula 1 Spa 2026',
        'category_id' => $catSport->id,
        'start_date' => now()->addDays(40),
        'is_published' => true,
    ]);

    Livewire::test(Home::class)
        ->assertViewHas('events', function ($events) use ($festivalEvent, $sportEvent) {
            return $events->contains($festivalEvent) && $events->contains($sportEvent);
        })
        ->set('selectedCategory', 'festivals')
        ->assertViewHas('events', function ($events) use ($festivalEvent, $sportEvent) {
            return $events->contains($festivalEvent) && !$events->contains($sportEvent);
        });
});

test('homepage search works', function () {
    $category = Category::factory()->create(['name' => 'Festivals', 'slug' => 'festivals']);
    
    $event1 = Event::factory()->create([
        'title' => 'Amsterdam Dance Event',
        'category_id' => $category->id,
        'start_date' => now()->addDays(30),
        'is_published' => true,
    ]);

    $event2 = Event::factory()->create([
        'title' => 'Graspop Metal Meeting 2026',
        'category_id' => $category->id,
        'start_date' => now()->addDays(40),
        'is_published' => true,
    ]);

    Livewire::test(Home::class)
        ->assertViewHas('events', function ($events) use ($event1, $event2) {
            return $events->contains($event1) && $events->contains($event2);
        })
        ->set('search', 'Amsterdam')
        ->assertViewHas('events', function ($events) use ($event1, $event2) {
            return $events->contains($event1) && !$events->contains($event2);
        });
});

