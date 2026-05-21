<?php

namespace App\Livewire\Dashboard\Master;

use App\Models\Organization;
use App\Models\User;
use App\Models\Event;
use App\Models\Order;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        // Het Master Dashboard haalt data op over ALLE organisaties en orders
        $orders = Order::withoutGlobalScopes()
            ->with(['event', 'organization', 'user', 'tickets'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $total_revenue_cents = Order::withoutGlobalScopes()
            ->where('status', 'paid')
            ->sum('total_cents');

        $total_paid_orders = Order::withoutGlobalScopes()
            ->where('status', 'paid')
            ->count();

        return view('livewire.dashboard.master.index', [
            'organizations' => Organization::withCount(['events', 'users'])->get(),
            'total_users' => User::count(),
            'total_events' => Event::count(),
            'orders' => $orders,
            'total_revenue_cents' => $total_revenue_cents,
            'total_paid_orders' => $total_paid_orders,
        ])->layout('layouts.app', ['title' => 'Master Admin Dashboard']);
    }
}
