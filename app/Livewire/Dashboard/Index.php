<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $organization = Auth::user()->organization;

        // Omzet = totale bedrag van orders minus de platform fee (als die bestaat)
        // Maar we houden het simpel: Totale ticket opbrengst voor deze tenant
        $orders = \App\Models\Order::where('organization_id', $organization->id)->get();
        $totalRevenue = $orders->sum('total_amount');
        
        // Hoeveelheid verkochte tickets
        $totalTicketsSold = \App\Models\Ticket::where('organization_id', $organization->id)->count();

        // Actieve events
        $activeEventsCount = \App\Models\Event::where('organization_id', $organization->id)
                                ->where('start_date', '>=', now())
                                ->count();

        // Recente orders
        $recentOrders = \App\Models\Order::with(['event', 'user'])
                            ->where('organization_id', $organization->id)
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        return view('livewire.dashboard.index', [
            'totalRevenue' => $totalRevenue,
            'totalTicketsSold' => $totalTicketsSold,
            'activeEventsCount' => $activeEventsCount,
            'recentOrders' => $recentOrders,
        ])->layout('layouts.app', ['title' => 'Tenant Dashboard']);
    }
}
