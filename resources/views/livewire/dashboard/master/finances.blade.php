<div class="space-y-8 bg-[#001E2B] p-6 rounded-3xl border border-white/5 min-h-[85vh] text-white">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-white/5 pb-6">
        <div>
            <h1 class="text-3xl font-black uppercase tracking-tight text-[#00ED64]">
                Financiën & <span class="text-white">Uitbetalingen</span>
            </h1>
            <p class="text-white/60 text-sm mt-1">Overzicht van omzet, platform fees en uitbetalingen per organisatie.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard.master') }}" class="px-4 py-2 bg-[#081621] border border-white/10 hover:border-[#00ED64]/50 rounded-xl text-xs font-bold uppercase tracking-wider transition-all text-white hover:scale-105">
                Dashboard
            </a>
        </div>
    </div>

    <!-- Key Metrics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-[#081621] border border-[#00ED64]/20 p-6 rounded-2xl flex flex-col justify-between shadow-lg shadow-[#00ED64]/5 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 opacity-5">
                <flux:icon icon="currency-euro" class="w-32 h-32" />
            </div>
            <span class="text-[#00ED64] text-xs font-bold uppercase tracking-wider relative z-10">Totale Platform Winst (Fees)</span>
            <div class="flex justify-between items-end mt-4 relative z-10">
                <span class="text-3xl font-mono font-black text-white">
                    €{{ number_format($totalPlatformFeeCents / 100, 2, ',', '.') }}
                </span>
                <span class="text-[10px] text-[#00ED64] bg-[#00ED64]/10 px-2 py-0.5 rounded font-bold">GrapATix Winst</span>
            </div>
        </div>

        <div class="bg-[#081621] border border-white/5 p-6 rounded-2xl flex flex-col justify-between">
            <span class="text-white/50 text-xs font-bold uppercase tracking-wider">Bruto Omzet (Alle Organisaties)</span>
            <div class="flex justify-between items-end mt-4">
                <span class="text-xl font-mono font-black text-white/80">
                    €{{ number_format($totalPlatformRevenueCents / 100, 2, ',', '.') }}
                </span>
                <span class="text-[10px] text-white/50 px-2 py-0.5 rounded font-bold">Verwerkt door platform</span>
            </div>
        </div>
    </div>

    <!-- Finances Table -->
    <div class="bg-[#081621] border border-white/5 rounded-2xl overflow-hidden shadow-xl">
        <div class="px-6 py-5 border-b border-white/5 bg-[#001E2B]/50 flex justify-between items-center">
            <div>
                <h2 class="font-bold text-lg text-white">Omzet per Organisatie</h2>
                <p class="text-white/50 text-xs mt-0.5">Details van inkomsten en de platform fee per tenant.</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-[#001E2B]/30 text-white/50 text-xs uppercase font-bold border-b border-white/5">
                    <tr>
                        <th class="px-6 py-4">Organisatie</th>
                        <th class="px-6 py-4 text-center">Betaalde Orders</th>
                        <th class="px-6 py-4 text-right">Bruto Omzet</th>
                        <th class="px-6 py-4 text-right text-[#00ED64]">Platform Fee (Winst)</th>
                        <th class="px-6 py-4 text-right">Netto Uitbetaling</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($organizationsData as $org)
                        <tr class="hover:bg-white/[0.02] transition-colors text-sm">
                            <td class="px-6 py-4">
                                <div class="font-bold text-white">{{ $org->name }}</div>
                                <div class="text-white/40 text-xs font-mono">{{ $org->subdomain }}.grapatix.be</div>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-white/80">
                                {{ $org->paid_orders_count }}
                            </td>
                            <td class="px-6 py-4 text-right font-mono text-white/80">
                                €{{ number_format($org->total_revenue_cents / 100, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right font-mono font-bold text-[#00ED64] bg-[#00ED64]/[0.02]">
                                €{{ number_format($org->platform_fee_cents / 100, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right font-mono font-bold text-white">
                                €{{ number_format($org->payout_cents / 100, 2, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-white/40">Geen financiële gegevens gevonden.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
