<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display the specified ticket.
     */
    public function show(Ticket $ticket)
    {
        // Optioneel: controleer of de ingelogde gebruiker de eigenaar is van dit ticket
        // $this->authorize('view', $ticket); // Als policies zijn ingesteld

        // Laad de relaties om event info etc. te kunnen tonen
        $ticket->load(['event', 'ticketType', 'user']);

        return view('tickets.show', compact('ticket'));
    }
}
