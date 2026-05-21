<div class="space-y-8 bg-[#001E2B] p-6 rounded-3xl border border-white/5 min-h-[85vh] text-white">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-white/5 pb-6">
        <div>
            <h1 class="text-3xl font-black uppercase tracking-tight text-[#00ED64]">
                Organisatie <span class="text-white">Dashboard</span>
            </h1>
            <p class="text-white/60 text-sm mt-1">Welkom terug, {{ auth()->user()->name }}! Hier is een overzicht van jouw ticketverkoop.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('events.index') }}" class="px-6 py-3 bg-[#00ED64] text-[#001E2B] rounded-xl text-sm font-bold uppercase tracking-wider transition-all shadow-md shadow-[#00ED64]/20 hover:scale-105 flex items-center gap-2">
                <flux:icon icon="plus" class="size-5" />
                Nieuw Evenement
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Revenue Card -->
        <div class="bg-[#081621] p-6 rounded-2xl border border-white/5 flex flex-col gap-4 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#00ED64]/5 rounded-full blur-2xl group-hover:bg-[#00ED64]/10 transition-colors"></div>
            <div class="flex justify-between items-start">
                <div class="p-3 bg-[#001E2B] rounded-xl border border-white/5">
                    <flux:icon icon="banknotes" class="size-6 text-[#00ED64]" />
                </div>
            </div>
            <div>
                <p class="text-white/50 text-sm font-medium mb-1">Totale Omzet</p>
                <h3 class="text-3xl font-black text-white">€{{ number_format($totalRevenue, 2, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Tickets Sold Card -->
        <div class="bg-[#081621] p-6 rounded-2xl border border-white/5 flex flex-col gap-4 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-colors"></div>
            <div class="flex justify-between items-start">
                <div class="p-3 bg-[#001E2B] rounded-xl border border-white/5">
                    <flux:icon icon="ticket" class="size-6 text-white" />
                </div>
            </div>
            <div>
                <p class="text-white/50 text-sm font-medium mb-1">Verkochte Tickets</p>
                <h3 class="text-3xl font-black text-white">{{ $totalTicketsSold }}</h3>
            </div>
        </div>

        <!-- Active Events Card -->
        <div class="bg-[#081621] p-6 rounded-2xl border border-white/5 flex flex-col gap-4 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#00ED64]/5 rounded-full blur-2xl group-hover:bg-[#00ED64]/10 transition-colors"></div>
            <div class="flex justify-between items-start">
                <div class="p-3 bg-[#001E2B] rounded-xl border border-white/5">
                    <flux:icon icon="calendar" class="size-6 text-[#00ED64]" />
                </div>
            </div>
            <div>
                <p class="text-white/50 text-sm font-medium mb-1">Actieve Evenementen</p>
                <h3 class="text-3xl font-black text-white">{{ $activeEventsCount }}</h3>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-[#081621] rounded-2xl border border-white/5 overflow-hidden">
        <div class="p-6 border-b border-white/5 flex justify-between items-center bg-[#001E2B]/50">
            <div>
                <h2 class="font-bold text-lg text-white">Recente Bestellingen</h2>
                <p class="text-white/50 text-xs mt-0.5">Laatste 5 transacties.</p>
            </div>
            <a href="{{ route('orders.index') }}" class="text-xs text-[#00ED64] hover:text-white font-medium flex items-center gap-1 transition-colors">
                Bekijk alles <flux:icon icon="arrow-right" class="size-3" />
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase text-white/40 bg-white/5">
                    <tr>
                        <th class="px-6 py-4 font-medium tracking-wider">Bestelnummer</th>
                        <th class="px-6 py-4 font-medium tracking-wider">Klant</th>
                        <th class="px-6 py-4 font-medium tracking-wider">Evenement</th>
                        <th class="px-6 py-4 font-medium tracking-wider text-right">Bedrag</th>
                        <th class="px-6 py-4 font-medium tracking-wider">Status</th>
                        <th class="px-6 py-4 font-medium tracking-wider">Datum</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-4 font-medium text-white">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-xs font-bold text-[#00ED64]">
                                        {{ substr($order->user->name ?? 'G', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-white font-medium">{{ $order->user->name ?? 'Gast Koper' }}</div>
                                        <div class="text-white/40 text-xs">{{ $order->user->email ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-white/70">{{ $order->event->name ?? 'Onbekend' }}</td>
                            <td class="px-6 py-4 font-bold text-[#00ED64] text-right">€{{ number_format($order->total_amount, 2, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($order->status === 'paid')
                                    <span class="px-2 py-1 bg-[#00ED64]/10 text-[#00ED64] rounded-md text-xs font-bold border border-[#00ED64]/20">Betaald</span>
                                @elseif($order->status === 'pending')
                                    <span class="px-2 py-1 bg-amber-500/10 text-amber-500 rounded-md text-xs font-bold border border-amber-500/20">In behandeling</span>
                                @else
                                    <span class="px-2 py-1 bg-rose-500/10 text-rose-500 rounded-md text-xs font-bold border border-rose-500/20">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-white/50 text-xs">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-white/40">
                                Geen bestellingen gevonden.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
