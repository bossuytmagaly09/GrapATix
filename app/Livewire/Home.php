<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $events = Event::with(['category', 'media'])
            ->where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->take(6)
            ->get();

        return view('livewire.home', [
            'events' => $events,
        ])->layout('components.layouts.public');
    }
}
