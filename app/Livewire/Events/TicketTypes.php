<?php

namespace App\Livewire\Events;

use App\Models\Event;
use App\Models\TicketType;
use Livewire\Component;

class TicketTypes extends Component
{
    public Event $event;

    // Fields for new/edit ticket type
    public $name = '';
    public $price_cents = 0;
    public $available_quantity = 100;
    public $is_published = false;
    
    // For editing an existing one
    public $editingId = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'price_cents' => 'required|integer|min:0',
        'available_quantity' => 'required|integer|min:1',
        'is_published' => 'boolean',
    ];

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function resetForm()
    {
        $this->name = '';
        $this->price_cents = 0;
        $this->available_quantity = 100;
        $this->is_published = false;
        $this->editingId = null;
    }

    public function edit($id)
    {
        $ticketType = TicketType::where('event_id', $this->event->id)->findOrFail($id);
        $this->editingId = $ticketType->id;
        $this->name = $ticketType->name;
        $this->price_cents = $ticketType->price_cents;
        $this->available_quantity = $ticketType->available_quantity;
        $this->is_published = $ticketType->is_published;
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId && $this->editingId !== 'new') {
            $ticketType = TicketType::where('event_id', $this->event->id)->findOrFail($this->editingId);
            $ticketType->update([
                'name' => $this->name,
                'price_cents' => $this->price_cents,
                'available_quantity' => $this->available_quantity,
                'is_published' => $this->is_published,
                'published_at' => $this->is_published && !$ticketType->published_at ? now() : $ticketType->published_at,
            ]);
            \Flux::toast('Ticket type succesvol bijgewerkt.', 'success');
        } else {
            TicketType::create([
                'event_id' => $this->event->id,
                'name' => $this->name,
                'price_cents' => $this->price_cents,
                'available_quantity' => $this->available_quantity,
                'is_published' => $this->is_published,
                'published_at' => $this->is_published ? now() : null,
            ]);
            \Flux::toast('Nieuw ticket type succesvol toegevoegd.', 'success');
        }

        $this->resetForm();
    }

    public function delete($id)
    {
        $ticketType = TicketType::where('event_id', $this->event->id)->findOrFail($id);
        
        // Let op: In een echte applicatie controleer je eerst of er al tickets verkocht zijn!
        if ($ticketType->tickets()->count() > 0) {
            \Flux::toast('Kan ticket type niet verwijderen omdat er al tickets van dit type verkocht zijn.', 'danger');
            return;
        }

        $ticketType->delete();
        \Flux::toast('Ticket type succesvol verwijderd.', 'success');
    }

    public function render()
    {
        return view('livewire.events.ticket-types', [
            'ticketTypes' => $this->event->ticketTypes()->latest()->get(),
        ])->layout('layouts.app', ['title' => 'Tickets Beheren']);
    }
}
