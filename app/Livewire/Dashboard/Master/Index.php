<?php

namespace App\Livewire\Dashboard\Master;

use App\Models\Organization;
use App\Models\User;
use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\ScanLog;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Index extends Component
{
    #[Computed]
    public function organizations()
    {
        return Organization::withCount([
            'events' => function ($query) {
                $query->withoutGlobalScopes();
            },
            'users' => function ($query) {
                $query->withoutGlobalScopes();
            }
        ])->get();
    }

    #[Computed]
    public function totalUsers()
    {
        return User::withoutGlobalScopes()->count();
    }

    #[Computed]
    public function totalEvents()
    {
        return Event::withoutGlobalScopes()->count();
    }

    #[Computed]
    public function totalRevenueCents()
    {
        return Order::withoutGlobalScopes()
            ->where('status', 'paid')
            ->sum('total_cents');
    }

    #[Computed]
    public function totalPaidOrders()
    {
        return Order::withoutGlobalScopes()
            ->where('status', 'paid')
            ->count();
    }

    #[Computed]
    public function orders()
    {
        return Order::withoutGlobalScopes()
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
    }

    #[Computed]
    public function globalScanStats()
    {
        $stats = ScanLog::withoutGlobalScopes()
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

    #[Computed]
    public function topPerformingOrganizations()
    {
        return Organization::withCount([
            'events' => function ($query) {
                $query->withoutGlobalScopes();
            }
        ])
        ->get()
        ->map(function ($org) {
            $paidOrders = Order::withoutGlobalScopes()
                ->where('organization_id', $org->id)
                ->where('status', 'paid')
                ->get();

            $org->revenue = $paidOrders->sum('total_cents') / 100;
            $org->tickets_sold = Ticket::withoutGlobalScopes()
                ->where('organization_id', $org->id)
                ->whereIn('status', ['paid', 'scanned'])
                ->count();

            return $org;
        })
        ->sortByDesc('revenue')
        ->take(5);
    }

    public function render()
    {
        return view('livewire.dashboard.master.index', [
            'organizations' => $this->organizations,
            'total_users' => $this->totalUsers,
            'total_events' => $this->totalEvents,
            'orders' => $this->orders,
            'total_revenue_cents' => $this->totalRevenueCents,
            'total_paid_orders' => $this->totalPaidOrders,
        ])->layout('layouts.app', ['title' => 'Master Admin Dashboard']);
    }
}
