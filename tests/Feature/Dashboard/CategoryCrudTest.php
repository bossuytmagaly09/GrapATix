<?php

namespace Tests\Feature\Dashboard;

use App\Models\Category;
use App\Models\User;
use App\Livewire\Categories\Index as CategoriesIndex;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('authenticated users can see categories', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('categories.index'))
        ->assertStatus(200);
});

test('categories can be created through livewire', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(CategoriesIndex::class)
        ->set('name', 'Nieuwe Categorie')
        ->set('slug', 'nieuwe-categorie')
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('categories', [
        'name' => 'Nieuwe Categorie',
        'slug' => 'nieuwe-categorie',
    ]);
});

test('categories can be updated through livewire', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create(['name' => 'Oude Naam']);

    Livewire::actingAs($user)
        ->test(CategoriesIndex::class)
        ->call('edit', $category->id)
        ->set('name', 'Verbeterde Naam')
        ->call('save')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Verbeterde Naam',
    ]);
});

test('categories can be deleted through livewire', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    Livewire::actingAs($user)
        ->test(CategoriesIndex::class)
        ->call('delete', $category->id);

    $this->assertSoftDeleted('categories', [
        'id' => $category->id,
    ]);
});

test('organization categories can be enabled via categories index page', function () {
    $user = User::factory()->create();
    $organization = $user->organization;
    
    // Set initially to false
    $organization->update(['uses_categories' => false]);

    Livewire::actingAs($user)
        ->test(CategoriesIndex::class)
        ->assertSet('usesCategories', false)
        ->assertSee('Categorieën staan')
        ->assertSee('Uit')
        ->call('enableCategories')
        ->assertSet('usesCategories', true)
        ->assertSee('Manage your event categories');

    $this->assertTrue($organization->fresh()->uses_categories);
});
