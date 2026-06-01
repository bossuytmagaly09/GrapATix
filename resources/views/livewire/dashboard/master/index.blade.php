<div wire:poll.10s class="space-y-8 bg-[#001E2B] p-6 rounded-3xl border border-white/5 min-h-[85vh] text-white">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-white/5 pb-6">
        <div>
            <h1 class="text-3xl font-black uppercase tracking-tight text-[#00ED64] flex items-center gap-2">
                Master Admin <span class="text-white">Control Panel</span>
                <span class="relative flex h-3 w-3 ml-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#00ED64] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-[#00ED64]"></span>
                </span>
            </h1>
            <p class="text-white/60 text-sm mt-1">Algemeen beheer en realtime transactie-overzicht van het platform.</p>
        </div>
        <div class="flex items-center gap-3">
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
        <div class="bg-[#081621] border border-white/5 p-6 rounded-2xl flex flex-col justify-between hover:border-[#00ED64]/20 transition-all group">
            <span class="text-white/50 text-xs font-bold uppercase tracking-wider">Organisaties</span>
            <div class="flex justify-between items-end mt-4">
                <span class="text-3xl font-black group-hover:text-[#00ED64] transition-colors">{{ $organizations->count() }}</span>
                <span class="text-[10px] text-[#00ED64] bg-[#00ED64]/10 px-2 py-0.5 rounded font-bold">Active</span>
            </div>
        </div>

        <div class="bg-[#081621] border border-white/5 p-6 rounded-2xl flex flex-col justify-between hover:border-[#00ED64]/20 transition-all group">
            <span class="text-white/50 text-xs font-bold uppercase tracking-wider">Gebruikers</span>
            <div class="flex justify-between items-end mt-4">
                <span class="text-3xl font-black group-hover:text-[#00ED64] transition-colors">{{ $total_users }}</span>
                <span class="text-[10px] text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded font-bold">Registered</span>
            </div>
        </div>

        <div class="bg-[#081621] border border-white/5 p-6 rounded-2xl flex flex-col justify-between hover:border-[#00ED64]/20 transition-all group">
            <span class="text-white/50 text-xs font-bold uppercase tracking-wider">Evenementen</span>
            <div class="flex justify-between items-end mt-4">
                <span class="text-3xl font-black group-hover:text-[#00ED64] transition-colors">{{ $total_events }}</span>
                <span class="text-[10px] text-purple-400 bg-purple-500/10 px-2 py-0.5 rounded font-bold">Live</span>
            </div>
        </div>

        <div class="bg-[#081621] border border-[#00ED64]/20 p-6 rounded-2xl flex flex-col justify-between shadow-lg shadow-[#00ED64]/5 group">
            <span class="text-[#00ED64] text-xs font-bold uppercase tracking-wider">Stripe Orders</span>
            <div class="flex justify-between items-end mt-4">
                <span class="text-2xl font-mono font-black text-white bg-[#001E2B] px-3 py-1 rounded-xl border border-white/5">{{ $total_paid_orders }}</span>
                <span class="text-[10px] text-[#00ED64] font-bold">Paid</span>
            </div>
        </div>

        <div class="bg-[#081621] border border-[#00ED64]/20 p-6 rounded-2xl flex flex-col justify-between shadow-lg shadow-[#00ED64]/5 group">
            <span class="text-[#00ED64] text-xs font-bold uppercase tracking-wider">Platform Omzet</span>
            <div class="flex justify-between items-end mt-4">
                <span class="text-lg font-mono font-black text-[#00ED64] bg-[#001E2B] px-3 py-1 rounded-xl border border-white/5">
                    €{{ number_format($total_revenue_cents / 100, 2, ',', '.') }}
                </span>
                <span class="text-[10px] text-white/50 font-bold">EUR</span>
            </div>
        </div>
    </div>

    <!-- Quick Navigation Panels -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('dashboard.master.organizations') }}" class="group bg-[#081621] border border-white/5 hover:border-[#00ED64]/30 p-6 rounded-2xl flex justify-between items-center transition-all">
            <div class="space-y-1">
                <h3 class="font-bold text-lg group-hover:text-[#00ED64] transition-colors flex items-center gap-2">
                    <span>🏢 Beheer Organisaties</span>
                    <flux:icon icon="arrow-right" class="size-4 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all" />
                </h3>
                <p class="text-white/50 text-xs">Nieuwe tenants registreren, subdomeinen instellen en eventstatistieken inzien.</p>
            </div>
            <div class="bg-[#001E2B] p-3 rounded-xl border border-white/5 group-hover:bg-[#00ED64]/10 transition-colors">
                <flux:icon icon="building-office-2" class="size-6 text-[#00ED64]" />
            </div>
        </a>

        <a href="{{ route('dashboard.master.users') }}" class="group bg-[#081621] border border-white/5 hover:border-[#00ED64]/30 p-6 rounded-2xl flex justify-between items-center transition-all">
            <div class="space-y-1">
                <h3 class="font-bold text-lg group-hover:text-[#00ED64] transition-colors flex items-center gap-2">
                    <span>👥 Beheer Gebruikers</span>
                    <flux:icon icon="arrow-right" class="size-4 opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all" />
                </h3>
                <p class="text-white/50 text-xs">Machtigen van master admins, tenants toewijzen en algemene accountgegevens bewerken.</p>
            </div>
            <div class="bg-[#001E2B] p-3 rounded-xl border border-white/5 group-hover:bg-[#00ED64]/10 transition-colors">
                <flux:icon icon="users" class="size-6 text-[#00ED64]" />
            </div>
        </a>
    </div>

    <!-- Live Platform Scan Monitor & Top Performers -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Global Live Scan Monitor -->
        <div class="bg-[#081621] border border-white/5 rounded-2xl p-6 flex flex-col justify-between shadow-xl">
            <div class="border-b border-white/5 pb-4 mb-4">
                <h2 class="font-bold text-lg text-white flex items-center gap-2">
                    <flux:icon icon="bolt" class="size-5 text-[#00ED64] animate-pulse" />
                    Global Live Scan Monitor
                </h2>
                <p class="text-white/50 text-xs mt-0.5">Realtime overzicht van alle ticket validaties.</p>
            </div>

            <div class="space-y-6 my-auto">
                <div class="flex items-center gap-6 bg-[#001E2B]/50 p-4 rounded-xl border border-white/5">
                    <div class="relative w-16 h-16 flex items-center justify-center rounded-full border-4 border-white/5 shrink-0">
                        <div class="absolute inset-0 rounded-full border-4 border-t-[#00ED64] border-r-[#00ED64] border-b-white/5 border-l-white/5 animate-spin" style="animation-duration: 4s;"></div>
                        <span class="text-sm font-black text-white">{{ $this->globalScanStats['success_rate'] }}%</span>
                    </div>
                    <div>
                        <span class="text-[10px] text-white/50 uppercase font-bold tracking-wider">Global Success Rate</span>
                        <div class="text-sm font-extrabold text-[#00ED64] mt-0.5">Platform Stabiel</div>
                        <p class="text-white/40 text-[9px] mt-0.5">Veilige token validatie actief</p>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-[#001E2B] p-3 rounded-xl border border-white/5 text-center">
                        <span class="text-[10px] text-white/50 font-bold uppercase block mb-1">Totaal</span>
                        <span class="text-lg font-black text-white">{{ $this->globalScanStats['total'] }}</span>
                    </div>
                    <div class="bg-[#00ED64]/5 border border-[#00ED64]/10 p-3 rounded-xl text-center">
                        <span class="text-[10px] text-[#00ED64] font-bold uppercase block mb-1">Succes</span>
                        <span class="text-lg font-black text-[#00ED64]">{{ $this->globalScanStats['success'] }}</span>
                    </div>
                    <div class="bg-amber-500/5 border border-amber-500/10 p-3 rounded-xl text-center">
                        <span class="text-[10px] text-amber-400 font-bold uppercase block mb-1">Duplicaat</span>
                        <span class="text-lg font-black text-amber-400">{{ $this->globalScanStats['duplicate'] }}</span>
                    </div>
                </div>

                @if($this->globalScanStats['invalid'] > 0)
                    <div class="bg-rose-500/10 border border-rose-500/20 p-4 rounded-xl flex items-start gap-3">
                        <flux:icon icon="exclamation-triangle" class="size-5 text-rose-400 shrink-0 mt-0.5" />
                        <div>
                            <div class="text-xs font-bold text-rose-400">Valse QR Codes Geblokkeerd</div>
                            <p class="text-white/60 text-[10px] mt-0.5">{{ $this->globalScanStats['invalid'] }} ongeldige scans geblokkeerd op het platform.</p>
                        </div>
                    </div>
                @else
                    <div class="bg-[#00ED64]/10 border border-[#00ED64]/20 p-4 rounded-xl flex items-center gap-3">
                        <flux:icon icon="check-circle" class="size-5 text-[#00ED64] shrink-0" />
                        <span class="text-xs text-white/80 font-medium">Alle gateways operationeel. Geen security alerts.</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Top Tenants Leaderboard -->
        <div class="bg-[#081621] border border-white/5 rounded-2xl p-6 lg:col-span-2 flex flex-col justify-between shadow-xl">
            <div class="border-b border-white/5 pb-4 mb-4 flex justify-between items-center">
                <div>
                    <h2 class="font-bold text-lg text-white">Top Presterende Organisaties</h2>
                    <p class="text-white/50 text-xs mt-0.5">Ranglijst gebaseerd op totale ticketomzet via het platform.</p>
                </div>
                <span class="text-[10px] text-[#00ED64] bg-[#00ED64]/10 border border-[#00ED64]/20 px-2.5 py-1 rounded-full font-bold uppercase tracking-wider">Top Tenants</span>
            </div>

            <div class="space-y-4 max-h-[300px] overflow-y-auto pr-1">
                @forelse($this->topPerformingOrganizations as $index => $org)
                    <div class="bg-[#001E2B]/50 p-4 rounded-xl border border-white/5 flex items-center justify-between gap-4 hover:border-[#00ED64]/20 transition-all group">
                        <div class="flex items-center gap-3 truncate">
                            <div class="w-8 h-8 rounded-full bg-white/5 border border-white/10 flex items-center justify-center font-bold text-white shrink-0 group-hover:border-[#00ED64]/30 transition-all">
                                {{ $index + 1 }}
                            </div>
                            <div class="truncate">
                                <h4 class="font-bold text-white group-hover:text-[#00ED64] transition-colors truncate text-sm">{{ $org->name }}</h4>
                                <span class="text-[10px] text-white/40">{{ $org->events_count }} evenementen • subdomain: <span class="font-mono text-white/50">{{ $org->subdomain }}</span></span>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <div class="text-sm font-mono font-black text-[#00ED64]">€{{ number_format($org->revenue, 2, ',', '.') }}</div>
                            <span class="text-[10px] text-white/40 font-bold block">{{ $org->tickets_sold }} sold tickets</span>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-white/40 text-sm">Geen organisaties met geregistreerde verkopen gevonden.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Stripe Orders Table -->
    <div class="bg-[#081621] border border-white/5 rounded-2xl overflow-hidden shadow-xl">
        <div class="px-6 py-5 border-b border-white/5 bg-[#001E2B]/50 flex justify-between items-center">
            <div>
                <h2 class="font-bold text-lg text-white">Platform Transactiegeschiedenis</h2>
                <p class="text-white/50 text-xs mt-0.5">Laatste 5 ticketbetalingen afgehandeld via Stripe Checkout.</p>
            </div>
            <div class="flex gap-3 items-center">
                <span class="bg-[#00ED64]/10 text-[#00ED64] text-[10px] font-bold px-3 py-1 rounded-full uppercase border border-[#00ED64]/20 tracking-wider hidden sm:inline-block">Live Payments</span>
                <a href="{{ route('dashboard.master.orders') }}" class="px-4 py-1.5 bg-[#00ED64]/10 hover:bg-[#00ED64] text-[#00ED64] hover:text-[#001E2B] border border-[#00ED64]/30 rounded-xl text-xs font-bold uppercase tracking-wider transition-all hover:scale-105">Bekijk Alles</a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-[#001E2B]/30 text-white/50 text-xs uppercase font-bold border-b border-white/5">
                    <tr>
                        <th class="px-6 py-4">Order</th>
                        <th class="px-6 py-4">Organisatie</th>
                        <th class="px-6 py-4">Koper</th>
                        <th class="px-6 py-4">Evenement</th>
                        <th class="px-6 py-4">Stripe Ref</th>
                        <th class="px-6 py-4 text-center">Tickets</th>
                        <th class="px-6 py-4">Bedrag</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Tijdstip</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($orders as $order)
                        <tr class="hover:bg-white/[0.02] transition-colors text-sm">
                            <td class="px-6 py-4 font-bold text-white">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-white/80 block max-w-[150px] truncate" title="{{ $order->organization?->name }}">{{ $order->organization?->name ?? 'Gast' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-white">{{ $order->user?->name ?? 'Gast Koper' }}</div>
                                <div class="text-white/40 text-xs">{{ $order->user?->email ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-white/70 max-w-[180px] truncate" title="{{ $order->event?->title }}">{{ $order->event?->title ?? __('Unknown Event') }}</td>
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs text-white/50 bg-[#001E2B] border border-white/5 px-2 py-0.5 rounded block max-w-[120px] truncate" title="{{ $order->payment_id }}">
                                    {{ $order->payment_id ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-[#00ED64]">{{ $order->tickets->count() }}</td>
                            <td class="px-6 py-4 font-bold text-white font-mono">€{{ number_format($order->total_cents / 100, 2, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($order->status === 'paid')
                                    <span class="bg-[#00ED64]/10 text-[#00ED64] text-[10px] font-bold px-2.5 py-1 rounded-full border border-[#00ED64]/20">Betaald</span>
                                @elseif($order->status === 'pending')
                                    <span class="bg-amber-500/10 text-amber-400 text-[10px] font-bold px-2.5 py-1 rounded-full border border-amber-500/20">In Afwachting</span>
                                @else
                                    <span class="bg-red-500/10 text-red-400 text-[10px] font-bold px-2.5 py-1 rounded-full border border-red-500/20">{{ $order->status }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-white/50 text-xs">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-10 text-center text-white/40">Geen transacties gevonden op het platform.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
