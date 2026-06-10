<?php

namespace App\Livewire;

use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Contact extends Component
{
    public $name = '';
    public $email = '';
    public $subject = '';
    public $message = '';
    public $success = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|min:10',
    ];

    protected $validationAttributes = [
        'name' => 'naam',
        'email' => 'e-mailadres',
        'subject' => 'onderwerp',
        'message' => 'bericht',
    ];

    public function submit()
    {
        $this->validate();

        // Stuur de e-mail met behulp van de geconfigureerde mailer naar het support e-mailadres
        Mail::to(config('mail.from.address', 'tickets@grapatix.be'))
            ->send(new ContactMessage(
                $this->name,
                $this->email,
                $this->subject,
                $this->message
            ));

        $this->success = true;

        // Reset de velden na verzenden
        $this->reset(['name', 'email', 'subject', 'message']);
    }

    public function render()
    {
        return view('livewire.contact')
            ->layout('components.layouts.public');
    }
}
