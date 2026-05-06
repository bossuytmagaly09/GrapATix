<?php

namespace App\Livewire;

use Livewire\Component;

class Auth extends Component
{
    public $isRegister = false;

    public function mount()
    {
        if (request()->routeIs('register')) {
            $this->isRegister = true;
        }
    }

    public function render()
    {
        return view('livewire.auth')
            ->layout('components.layouts.auth.split', [
                'title' => $this->isRegister ? 'Registreren' : 'Inloggen'
            ]);
    }
}
