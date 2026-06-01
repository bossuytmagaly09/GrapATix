<?php

namespace App\Livewire\Dashboard\Master;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
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
            ->when($this->search, function ($query) {
                $query->where('id', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('email', 'like', '%' . $this->search . '%')
                          ->orWhere('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('organization', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('livewire.dashboard.master.orders', [
            'orders' => $orders
        ])->layout('layouts.app', ['title' => 'Master Admin - Bestellingen']);
    }
}
