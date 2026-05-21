<div class="space-y-8 bg-[#001E2B] p-6 rounded-3xl border border-white/5 min-h-[85vh] text-white">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-white/5 pb-6">
        <div>
            <h1 class="text-3xl font-black uppercase tracking-tight text-[#00ED64]">
                Beheer <span class="text-white">Bestellingen</span>
            </h1>
            <p class="text-white/60 text-sm mt-1">Volledig overzicht van alle transacties op het platform.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard.master') }}" class="px-4 py-2 bg-[#081621] border border-white/10 hover:border-[#00ED64]/50 rounded-xl text-xs font-bold uppercase tracking-wider transition-all text-white hover:scale-105">
                Dashboard
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-[#081621] p-4 rounded-2xl border border-white/5 flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Zoek op ID, e-mailadres of organisatienaam..." icon="magnifying-glass" class="bg-[#001E2B] border-white/10 text-white rounded-xl focus:border-[#00ED64] w-full" />
        </div>
        <div class="w-full md:w-64">
            <flux:select wire:model.live="status" class="bg-[#001E2B] border-white/10 text-white rounded-xl focus:border-[#00ED64] w-full">
                <flux:select.option value="">Alle statussen</flux:select.option>
                <flux:select.option value="paid">Betaald (Paid)</flux:select.option>
                <flux:select.option value="pending">In Afwachting (Pending)</flux:select.option>
                <flux:select.option value="failed">Mislukt (Failed)</flux:select.option>
                <flux:select.option value="refunded">Terugbetaald (Refunded)</flux:select.option>
            </flux:select>
        </div>
    </div>

    <!-- Stripe Orders Table -->
    <div class="bg-[#081621] border border-white/5 rounded-2xl overflow-hidden shadow-xl">
        <div class="px-6 py-5 border-b border-white/5 bg-[#001E2B]/50 flex justify-between items-center">
            <div>
                <h2 class="font-bold text-lg text-white">Platform Transactiegeschiedenis</h2>
                <p class="text-white/50 text-xs mt-0.5">Alle ticketbetalingen afgehandeld via Stripe Checkout.</p>
            </div>
            <span class="bg-[#00ED64]/10 text-[#00ED64] text-[10px] font-bold px-3 py-1 rounded-full uppercase border border-[#00ED64]/20 tracking-wider">Master Overview</span>
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
                            <td colspan="9" class="px-6 py-10 text-center text-white/40">Geen transacties gevonden die voldoen aan je zoekopdracht.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
            <div class="px-6 py-4 border-t border-white/5 bg-[#001E2B]/30">
                {{ $orders->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>
