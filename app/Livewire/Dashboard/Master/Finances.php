<?php

namespace App\Livewire\Dashboard\Master;

use App\Models\Organization;
use App\Models\Order;
use Livewire\Component;

class Finances extends Component
{
    public function render()
    {
        // Haal alle organisaties op met de som van hun orders
        // Dit is een simpele implementatie. Voor echt gebruik wil je een platform fee percentage toepassen.
        $organizations = Organization::with(['orders' => function($query) {
                $query->where('status', 'paid');
            }])
            ->get()
            ->map(function ($org) {
                // Bereken totale omzet voor deze organisatie
                $totalCents = $org->orders->sum('total_cents');
                
                // Voorbeeld: GrapATix platform fee is standaard 5% (kan later uit settings komen)
                $platformFeePercentage = 0.05;
                $platformFeeCents = intval($totalCents * $platformFeePercentage);
                $payoutCents = $totalCents - $platformFeeCents;

                return (object)[
                    'id' => $org->id,
                    'name' => $org->name,
                    'subdomain' => $org->subdomain,
                    'paid_orders_count' => $org->orders->count(),
                    'total_revenue_cents' => $totalCents,
                    'platform_fee_cents' => $platformFeeCents,
                    'payout_cents' => $payoutCents,
                ];
            });

        // Bereken totale platform fee inkomsten
        $totalPlatformFeeCents = $organizations->sum('platform_fee_cents');
        $totalPlatformRevenueCents = $organizations->sum('total_revenue_cents');

        return view('livewire.dashboard.master.finances', [
            'organizationsData' => $organizations,
            'totalPlatformFeeCents' => $totalPlatformFeeCents,
            'totalPlatformRevenueCents' => $totalPlatformRevenueCents,
        ])->layout('layouts.app', ['title' => 'Master Admin - Financiën']);
    }
}
