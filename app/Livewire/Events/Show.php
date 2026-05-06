<?php

namespace App\Livewire\Events;

use App\Models\Event;
use Livewire\Component;

class Show extends Component
{
    public Event $event;

    public function mount(Event $event)
    {
        $this->event = $event->load(['category', 'media']);
    }

    public function render()
    {
        return view('livewire.events.show')
            ->layout('components.layouts.public', [
                'title' => $this->event->title . ' | GrapATix'
            ]);
    }
}
