<?php

namespace App\Livewire\Dashboard\Master;

use Livewire\Component;

class Settings extends Component
{
    public $platform_name = 'GrapATix';
    public $support_email = 'support@grapatix.be';
    public $platform_fee_percentage = 5;
    public $stripe_mode = 'test';

    public function mount()
    {
        // In een echte applicatie haal je dit uit een settings tabel of config
        // Voor nu simuleren we dit.
    }

    public function save()
    {
        // Logica om op te slaan in database (Settings model)
        // Voor nu laten we enkel een succes-melding zien

        \Flux::toast('Platform instellingen zijn succesvol opgeslagen.', 'success');
    }

    public function render()
    {
        return view('livewire.dashboard.master.settings')->layout('layouts.app', ['title' => 'Master Admin - Instellingen']);
    }
}
