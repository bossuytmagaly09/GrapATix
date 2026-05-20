<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-[#001E2B]">Master Admin Dashboard</h1>
        <div class="px-4 py-1.5 bg-[#00ED64] text-[#001E2B] rounded-full text-xs font-bold uppercase tracking-wider">
            Platform Overzicht
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium mb-1">Organisaties</div>
            <div class="text-3xl font-bold text-[#001E2B]">{{ $organizations->count() }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium mb-1">Gebruikers</div>
            <div class="text-3xl font-bold text-[#001E2B]">{{ $total_users }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium mb-1">Evenementen</div>
            <div class="text-3xl font-bold text-[#001E2B]">{{ $total_events }}</div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="text-gray-500 text-xs font-medium mb-1">Stripe Transacties</div>
            <div class="text-xl font-bold text-[#00ED64] bg-[#001E2B] inline-block px-3 py-1 rounded-xl w-fit mt-1 select-all font-mono">
                {{ $total_paid_orders }}
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="text-gray-500 text-xs font-medium mb-1">Totale Omzet</div>
            <div class="text-xl font-bold text-[#00ED64] bg-[#001E2B] inline-block px-3 py-1 rounded-xl w-fit mt-1 select-all font-mono">
                €{{ number_format($total_revenue_cents / 100, 2, ',', '.') }}
            </div>
        </div>
    </div>

    <!-- Organizations Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <h2 class="font-bold text-[#001E2B]">Geregistreerde Organisaties (Tenants)</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold">
                    <tr>
                        <th class="px-6 py-4">Naam</th>
                        <th class="px-6 py-4">Subdomein (Slug)</th>
                        <th class="px-6 py-4 text-center">Events</th>
                        <th class="px-6 py-4 text-center">Users</th>
                        <th class="px-6 py-4">Gemaakt op</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($organizations as $org)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-[#001E2B]">{{ $org->name }}</td>
                            <td class="px-6 py-4 text-gray-500 font-mono text-sm">{{ $org->subdomain }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-blue-50 text-blue-700 px-2.5 py-0.5 rounded-full text-xs font-bold">{{ $org->events_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-purple-50 text-purple-700 px-2.5 py-0.5 rounded-full text-xs font-bold">{{ $org->users_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-sm">{{ $org->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Stripe Orders Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
            <h2 class="font-bold text-[#001E2B]">Alle Platform Transacties (Stripe)</h2>
            <span class="bg-[#001E2B] text-[#00ED64] text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Live Stripe</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold">
                    <tr>
                        <th class="px-6 py-4">Bestelling</th>
                        <th class="px-6 py-4">Organisatie</th>
                        <th class="px-6 py-4">Klant</th>
                        <th class="px-6 py-4">Evenement</th>
                        <th class="px-6 py-4">Stripe ID</th>
                        <th class="px-6 py-4 text-center">Tickets</th>
                        <th class="px-6 py-4">Totaal</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Datum</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-bold text-[#001E2B]">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-zinc-800 text-sm">{{ $order->organization?->name ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="font-bold text-[#001E2B]">{{ $order->user?->name ?? 'Gast Koper' }}</div>
                                <div class="text-gray-400 text-xs">{{ $order->user?->email ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-sm font-medium">{{ $order->event?->title ?? __('Unknown Event') }}</td>
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded">
                                    {{ $order->payment_id ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-gray-700 text-sm">{{ $order->tickets->count() }}</td>
                            <td class="px-6 py-4 font-bold text-[#001E2B] text-sm">€{{ number_format($order->total_cents / 100, 2, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($order->status === 'paid')
                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded-full">Betaald</span>
                                @elseif($order->status === 'pending')
                                    <span class="bg-amber-100 text-amber-800 text-xs font-bold px-2.5 py-1 rounded-full">In afwachting</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-1 rounded-full">{{ $order->status }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-sm">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-500">Geen transacties gevonden op het platform.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
