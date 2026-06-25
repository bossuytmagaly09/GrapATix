<?php

namespace App\Livewire\Dashboard;

use App\Models\Event;
use App\Models\Ticket;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;

class Scanner extends Component
{
    public Event $event;
    public int $totalTicketsCount = 0;
    public int $scannedTicketsCount = 0;

    /**
     * Mount the component.
     */
    public function mount(Event $event)
    {
        // Bypass global tenant scopes temporarily to find the event if scanned by master admin
        // or check authorization
        $this->event = Event::withoutGlobalScopes()
            ->with('venue')
            ->findOrFail($event->id);

        // Security check: verify the user belongs to the organization of this event
        $user = auth()->user();
        if (!$user->can('access-master-dashboard') && $this->event->organization_id !== $user->organization_id) {
            abort(403, 'Je hebt geen toegang tot de scanner van dit evenement.');
        }

        $this->loadStats();
    }

    /**
     * Load the current statistics of the event.
     */
    public function loadStats()
    {
        $this->totalTicketsCount = Ticket::withoutGlobalScopes()
            ->where('event_id', $this->event->id)
            ->count();

        $this->scannedTicketsCount = Ticket::withoutGlobalScopes()
            ->where('event_id', $this->event->id)
            ->whereNotNull('scanned_at')
            ->count();
    }

    /**
     * Livewire action to refresh the statistics (used by polling or manual refresh).
     */
    public function refreshStats()
    {
        $this->loadStats();
        
        return [
            'total' => $this->totalTicketsCount,
            'scanned' => $this->scannedTicketsCount
        ];
    }

    /**
     * Get the recent scan history.
     */
    public function getScannedHistoryProperty()
    {
        return Ticket::withoutGlobalScopes()
            ->with(['ticketType', 'user', 'scannedBy'])
            ->where('event_id', $this->event->id)
            ->whereNotNull('scanned_at')
            ->orderBy('scanned_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'code' => 'GTX-' . strtoupper(substr(md5($ticket->id), 0, 8)),
                    'ticket_type' => $ticket->ticketType->name ?? 'Standaard',
                    'customer_name' => $ticket->user->name ?? 'Gast/Klant',
                    'scanned_at' => $ticket->scanned_at->timezone('Europe/Brussels')->format('H:i:s'),
                    'scanned_by' => $ticket->scannedBy->name ?? 'Portier',
                ];
            });
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.dashboard.scanner', [
            'history' => $this->scannedHistory
        ])->layout('layouts.app', ['title' => 'Portiers Scanner | ' . $this->event->title]);
    }
}
