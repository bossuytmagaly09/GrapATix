<?php

use App\Models\User;

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertOk();
});

test('new users can register', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $user = User::where('email', 'test@example.com')->first();

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();
});

test('new users can register as tenant', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'Partner Org Admin',
        'email' => 'partner@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'register_as_organization' => '1',
        'organization_name' => 'My Partner Festival',
        'subdomain' => 'mypartner',
    ]);

    $response->assertSessionHasNoErrors()
        ->assertRedirect(route('dashboard', absolute: false));

    $this->assertAuthenticated();

    // Verify Organization was created
    $org = \App\Models\Organization::where('subdomain', 'mypartner')->first();
    expect($org)->not->toBeNull();
    expect($org->name)->toBe('My Partner Festival');

    // Verify User was created and associated with the organization
    $user = User::where('email', 'partner@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->organization_id)->toBe($org->id);
});