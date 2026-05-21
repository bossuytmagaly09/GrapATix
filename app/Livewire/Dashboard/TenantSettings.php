<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TenantSettings extends Component
{
    public $uses_categories = false;

    public function mount()
    {
        $organization = Auth::user()->organization;
        if ($organization) {
            $this->uses_categories = $organization->uses_categories;
        }
    }

    public function save()
    {
        $organization = Auth::user()->organization;
        if ($organization) {
            $organization->uses_categories = $this->uses_categories;
            $organization->save();
            
            \Flux::toast('Instellingen succesvol opgeslagen.', 'success');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.tenant-settings')->layout('layouts.app', ['title' => 'Organisatie Instellingen']);
    }
}
