<?php

namespace App\Livewire\Dashboard;

use App\Models\Order;
use Livewire\Component;

class Orders extends Component
{
    public function render()
    {
        // Automatically filtered by TenantScope if active_organization_id is in session
        $orders = Order::with(['event', 'user', 'tickets'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.dashboard.orders', [
            'orders' => $orders
        ])->layout('layouts.app', ['title' => 'Bestellingen & Stripe Betalingen']);
    }
}
