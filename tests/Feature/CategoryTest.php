<?php

use App\Models\Category;

test('a category can be created', function () {
    $category = Category::factory()->create([
        'name' => 'Concerts',
    ]);

    $this->assertDatabaseHas('categories', [
        'name' => 'Concerts',
    ]);
});

test('a category has a slug', function () {
    $category = Category::factory()->create([
        'name' => 'Theater Plays',
        'slug' => 'theater-plays',
    ]);

    expect($category->slug)->toBe('theater-plays');
});

test('a category can be updated', function () {
    $category = Category::factory()->create(['name' => 'Old Name']);

    $category->update(['name' => 'New Name']);

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'New Name',
    ]);
});

test('a category can be deleted', function () {
    $category = Category::factory()->create();

    $category->delete();

    $this->assertDatabaseMissing('categories', [
        'id' => $category->id,
    ]);
});
