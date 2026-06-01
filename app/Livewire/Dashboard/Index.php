<?php

namespace App\Livewire\Dashboard;

use App\Models\Event;
use App\Models\Order;
use App\Models\ScanLog;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Index extends Component
{
    #[Computed]
    public function organization()
    {
        return Auth::user()->organization;
    }

    #[Computed]
    public function totalRevenue()
    {
        $totalCents = Order::where('organization_id', $this->organization->id)
            ->where('status', 'paid')
            ->sum('total_cents');

        return $totalCents / 100;
    }

    #[Computed]
    public function totalTicketsSold()
    {
        return Ticket::where('organization_id', $this->organization->id)
            ->whereIn('status', ['paid', 'scanned'])
            ->count();
    }

    #[Computed]
    public function activeEventsCount()
    {
        return Event::where('organization_id', $this->organization->id)
            ->where('start_date', '>=', now())
            ->count();
    }

    #[Computed]
    public function recentOrders()
    {
        return Order::with(['event', 'user'])
            ->where('organization_id', $this->organization->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    #[Computed]
    public function revenueThisWeek()
    {
        $totalCents = Order::where('organization_id', $this->organization->id)
            ->where('status', 'paid')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('total_cents');

        return $totalCents / 100;
    }

    #[Computed]
    public function ticketsSoldPerEvent()
    {
        return Event::where('organization_id', $this->organization->id)
            ->withCount(['tickets' => function ($query) {
                $query->whereIn('status', ['paid', 'scanned']);
            }])
            ->with(['ticketTypes'])
            ->get()
            ->map(function ($event) {
                $totalCapacity = $event->ticketTypes->sum('available_quantity');
                $event->total_capacity = $totalCapacity > 0 ? $totalCapacity : ($event->max_capacity ?? 100);
                $event->fill_percentage = $event->total_capacity > 0 ? round(($event->tickets_count / $event->total_capacity) * 100, 1) : 0;
                return $event;
            });
    }

    #[Computed]
    public function scanStats()
    {
        $organizationId = $this->organization->id;

        $stats = ScanLog::whereHas('ticket', function ($query) use ($organizationId) {
            $query->where('organization_id', $organizationId);
        })
        ->selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 'success' THEN 1 ELSE 0 END) as success,
            SUM(CASE WHEN status = 'duplicate' THEN 1 ELSE 0 END) as duplicate,
            SUM(CASE WHEN status = 'invalid' THEN 1 ELSE 0 END) as invalid
        ")
        ->first();

        $total = $stats->total ?? 0;
        $success = $stats->success ?? 0;
        $duplicate = $stats->duplicate ?? 0;
        $invalid = $stats->invalid ?? 0;

        $successRate = $total > 0 ? round(($success / $total) * 100, 1) : 0;

        return [
            'total' => $total,
            'success' => $success,
            'duplicate' => $duplicate,
            'invalid' => $invalid,
            'success_rate' => $successRate,
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.index')
            ->layout('layouts.app', ['title' => 'Tenant Dashboard']);
    }
}
