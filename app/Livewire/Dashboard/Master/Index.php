<?php

namespace App\Livewire\Dashboard\Master;

use App\Models\Organization;
use App\Models\User;
use App\Models\Event;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        // Het Master Dashboard haalt data op over ALLE organisaties
        // Omdat dit buiten de tenant-context valt, moeten we oppassen met scoping (indien we die later globaal aanzetten)
        return view('livewire.dashboard.master.index', [
            'organizations' => Organization::withCount(['events', 'users'])->get(),
            'total_users' => User::count(),
            'total_events' => Event::count(),
        ])->layout('layouts.app', ['title' => 'Master Admin Dashboard']);
    }
}
