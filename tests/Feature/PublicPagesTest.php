<?php

use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

test('about page loads successfully', function () {
    $response = $this->get(route('about'));
    $response->assertStatus(200);
    $response->assertSee('Over GrapATix');
});

test('privacy page loads successfully', function () {
    $response = $this->get(route('privacy'));
    $response->assertStatus(200);
    $response->assertSee('Privacy Policy');
});

test('contact page loads successfully', function () {
    $response = $this->get(route('contact'));
    $response->assertStatus(200);
    $response->assertSee('Neem');
    $response->assertSee('Contact');
});

test('contact form validates input', function () {
    Livewire::test(\App\Livewire\Contact::class)
        ->call('submit')
        ->assertHasErrors(['name', 'email', 'subject', 'message']);
});

test('contact form sends contact email', function () {
    Mail::fake();

    Livewire::test(\App\Livewire\Contact::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Vraag')
        ->set('message', 'Dit is een test bericht met meer dan tien tekens.')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('success', true);

    Mail::assertSent(ContactMessage::class, function ($mail) {
        return $mail->hasTo(config('mail.from.address', 'tickets@grapatix.be')) &&
               $mail->name === 'John Doe' &&
               $mail->email === 'john@example.com' &&
               $mail->subjectText === 'Test Vraag' &&
               $mail->messageText === 'Dit is een test bericht met meer dan tien tekens.';
    });
});
