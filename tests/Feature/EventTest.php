<?php

use App\Models\Event;
use App\Models\Category;

test('an event can be created', function () {
    $event = Event::factory()->create([
        'title' => 'Summer Festival',
    ]);

    $this->assertDatabaseHas('events', [
        'title' => 'Summer Festival',
    ]);
});

test('an event belongs to a category', function () {
    $category = Category::factory()->create(['name' => 'Sport']);
    $event = Event::factory()->create(['category_id' => $category->id]);

    expect($event->category->name)->toBe('Sport');
});

test('an event can be updated', function () {
    $event = Event::factory()->create(['title' => 'Old Title']);

    $event->update(['title' => 'New Title']);

    $this->assertDatabaseHas('events', [
        'id' => $event->id,
        'title' => 'New Title',
    ]);
});

test('an event can be soft deleted', function () {
    $event = Event::factory()->create();

    $event->delete();

    // The record should still be in the database but with a deleted_at timestamp
    $this->assertSoftDeleted('events', [
        'id' => $event->id,
    ]);
});
