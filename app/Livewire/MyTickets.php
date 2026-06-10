<?php

namespace App\Livewire;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyTickets extends Component
{
    public function render()
    {
        // Haal alle geldige tickets van de ingelogde gebruiker op, onafhankelijk van tenant-scoping
        $tickets = Ticket::withoutGlobalScopes()
            ->with(['event.venue', 'ticketType'])
            ->where('user_id', Auth::id())
            ->whereIn('status', ['paid', 'scanned'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.my-tickets', [
            'tickets' => $tickets,
        ])->layout('components.layouts.public');
    }
}
