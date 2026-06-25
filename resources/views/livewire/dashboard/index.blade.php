<div wire:poll.5s class="space-y-8 bg-[#001E2B] p-6 rounded-3xl border border-white/5 min-h-[85vh] text-white">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-white/5 pb-6">
        <div>
            <h1 class="text-3xl font-black uppercase tracking-tight text-[#00ED64] flex items-center gap-2">
                Organisatie <span class="text-white">Dashboard</span>
                <span class="relative flex h-3 w-3 ml-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#00ED64] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-[#00ED64]"></span>
                </span>
            </h1>
            <p class="text-white/60 text-sm mt-1">Welkom terug, {{ auth()->user()->name }}! Hier zijn de live-statistieken van {{ $this->organization->name }}.</p>
        </div>

    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
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
                <h3 class="text-3xl font-black text-white">€{{ number_format($this->totalRevenue, 2, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Weekly Revenue Card -->
        <div class="bg-[#081621] p-6 rounded-2xl border border-[#00ED64]/20 flex flex-col gap-4 relative overflow-hidden group shadow-lg shadow-[#00ED64]/5">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-[#00ED64]/10 rounded-full blur-2xl group-hover:bg-[#00ED64]/25 transition-colors"></div>
            <div class="flex justify-between items-start">
                <div class="p-3 bg-[#001E2B] rounded-xl border border-[#00ED64]/30">
                    <flux:icon icon="banknotes" class="size-6 text-[#00ED64]" />
                </div>
                <span class="text-[10px] text-[#00ED64] bg-[#00ED64]/10 px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Deze Week</span>
            </div>
            <div>
                <p class="text-[#00ED64] text-sm font-medium mb-1">Omzet deze Week</p>
                <h3 class="text-3xl font-black text-white">€{{ number_format($this->revenueThisWeek, 2, ',', '.') }}</h3>
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
                <h3 class="text-3xl font-black text-white">{{ $this->totalTicketsSold }}</h3>
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
                <h3 class="text-3xl font-black text-white">{{ $this->activeEventsCount }}</h3>
            </div>
        </div>
    </div>

    <!-- Real-time Scan Statistics & Event Sales Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Scan Statistics Panel -->
        <div class="bg-[#081621] border border-white/5 rounded-2xl p-6 flex flex-col justify-between shadow-xl">
            <div class="border-b border-white/5 pb-4 mb-4">
                <h2 class="font-bold text-lg text-white flex items-center gap-2">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#00ED64] opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-[#00ED64]"></span>
                    </span>
                    Real-time Scanning
                </h2>
                <p class="text-white/50 text-xs mt-0.5">Live scanner statistieken per scanner/locatie.</p>
            </div>

            <div class="space-y-6 my-auto">
                <!-- Circular/Success Rate Widget -->
                <div class="flex items-center gap-6 bg-[#001E2B]/50 p-4 rounded-xl border border-white/5">
                    <div class="relative w-16 h-16 flex items-center justify-center rounded-full border-4 border-white/5 shrink-0">
                        <div class="absolute inset-0 rounded-full border-4 border-t-[#00ED64] border-r-[#00ED64] border-b-white/5 border-l-white/5 animate-spin" style="animation-duration: 3s;"></div>
                        <span class="text-sm font-black text-white">{{ $this->scanStats['success_rate'] }}%</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-white/50 uppercase font-bold tracking-wider">Scan Success Rate</span>
                        <div class="text-sm font-extrabold text-[#00ED64] mt-0.5">Uiterst Betrouwbaar</div>
                        <p class="text-white/40 text-[9px] mt-0.5">Gevalideerd via cryptografische tokens</p>
                    </div>
                </div>

                <!-- Stats Details -->
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-[#001E2B] p-3 rounded-xl border border-white/5 text-center">
                        <span class="text-[10px] text-white/50 font-bold uppercase block mb-1">Scans</span>
                        <span class="text-lg font-black text-white">{{ $this->scanStats['total'] }}</span>
                    </div>
                    <div class="bg-[#00ED64]/5 border border-[#00ED64]/10 p-3 rounded-xl text-center">
                        <span class="text-[10px] text-[#00ED64] font-bold uppercase block mb-1">Gescand</span>
                        <span class="text-lg font-black text-[#00ED64]">{{ $this->scanStats['success'] }}</span>
                    </div>
                    <div class="bg-amber-500/5 border border-amber-500/10 p-3 rounded-xl text-center">
                        <span class="text-[10px] text-amber-400 font-bold uppercase block mb-1">Duplicaten</span>
                        <span class="text-lg font-black text-amber-400">{{ $this->scanStats['duplicate'] }}</span>
                    </div>
                </div>

                @if($this->scanStats['invalid'] > 0)
                    <!-- Critical Alert -->
                    <div class="bg-rose-500/10 border border-rose-500/20 p-4 rounded-xl flex items-start gap-3">
                        <flux:icon icon="exclamation-triangle" class="size-5 text-rose-400 shrink-0 mt-0.5" />
                        <div>
                            <div class="text-xs font-bold text-rose-400">Verdachte Activiteit</div>
                            <p class="text-white/60 text-[10px] mt-0.5">{{ $this->scanStats['invalid'] }} ongeldige/valse QR-code scans geblokkeerd door het systeem.</p>
                        </div>
                    </div>
                @else
                    <!-- Status Normal -->
                    <div class="bg-[#00ED64]/10 border border-[#00ED64]/20 p-4 rounded-xl flex items-center gap-3">
                        <flux:icon icon="check-circle" class="size-5 text-[#00ED64] shrink-0" />
                        <div class="text-xs text-white/80 font-medium">Alle scanners rapporteren normale activiteit. Geen ongeldige tokens gedetecteerd.</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Event Sales Breakdown Panel -->
        <div class="bg-[#081621] border border-white/5 rounded-2xl p-6 lg:col-span-2 flex flex-col justify-between shadow-xl">
            <div class="border-b border-white/5 pb-4 mb-4 flex justify-between items-center">
                <div>
                    <h2 class="font-bold text-lg text-white">Ticketverkoop per Evenement</h2>
                    <p class="text-white/50 text-xs mt-0.5">Capaciteitsbenutting en verkoopstatistieken per evenement.</p>
                </div>
            </div>

            <div class="space-y-4 max-h-[300px] overflow-y-auto pr-1">
                @forelse($this->ticketsSoldPerEvent as $event)
                    <div class="bg-[#001E2B]/50 p-4 rounded-xl border border-white/5 space-y-2 hover:border-[#00ED64]/20 transition-all group">
                        <div class="flex justify-between items-center gap-4">
                            <div class="truncate">
                                <h4 class="font-bold text-white group-hover:text-[#00ED64] transition-colors truncate text-sm">{{ $event->title }}</h4>
                                <span class="text-[10px] text-white/40 font-medium">{{ $event->start_date->format('d M Y') }}</span>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="text-sm font-black text-white">{{ $event->tickets_count }}</span>
                                <span class="text-xs text-white/40">/ {{ $event->total_capacity }}</span>
                                <span class="text-xs text-[#00ED64] font-bold block">{{ $event->fill_percentage }}%</span>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="relative w-full h-2 bg-white/5 rounded-full overflow-hidden">
                            <div class="absolute top-0 left-0 h-full rounded-full transition-all duration-500 ease-out {{ $event->fill_percentage >= 100 ? 'bg-amber-500 shadow-md shadow-amber-500/20' : ($event->fill_percentage >= 80 ? 'bg-[#00ED64] shadow-md shadow-[#00ED64]/20' : 'bg-blue-500') }}"
                                 style="width: {{ min(100, $event->fill_percentage) }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-white/40 text-sm">Geen evenementen geregistreerd voor deze organisatie.</div>
                @endforelse
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
                    @forelse($this->recentOrders as $order)
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
                            <td class="px-6 py-4 text-white/70">{{ $order->event->title ?? 'Onbekend' }}</td>
                            <td class="px-6 py-4 font-bold text-[#00ED64] text-right">€{{ number_format($order->total_cents / 100, 2, ',', '.') }}</td>
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
