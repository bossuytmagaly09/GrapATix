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
            ->with([
                'event' => function ($query) {
                    $query->withoutGlobalScopes();
                },
                'organization',
                'user' => function ($query) {
                    $query->withoutGlobalScopes();
                },
                'tickets' => function ($query) {
                    $query->withoutGlobalScopes();
                }
            ])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $total_revenue_cents = Order::withoutGlobalScopes()
            ->where('status', 'paid')
            ->sum('total_cents');

        $total_paid_orders = Order::withoutGlobalScopes()
            ->where('status', 'paid')
            ->count();

        $organizations = Organization::withCount([
            'events' => function ($query) {
                $query->withoutGlobalScopes();
            },
            'users' => function ($query) {
                $query->withoutGlobalScopes();
            }
        ])->get();

        return view('livewire.dashboard.master.index', [
            'organizations' => $organizations,
            'total_users' => User::withoutGlobalScopes()->count(),
            'total_events' => Event::withoutGlobalScopes()->count(),
            'orders' => $orders,
            'total_revenue_cents' => $total_revenue_cents,
            'total_paid_orders' => $total_paid_orders,
        ])->layout('layouts.app', ['title' => 'Master Admin Dashboard']);
    }
}
