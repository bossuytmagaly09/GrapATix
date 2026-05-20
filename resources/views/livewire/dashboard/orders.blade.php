<div class="flex flex-col gap-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl">{{ __('Orders & Stripe Betalingen') }}</flux:heading>
            <flux:subheading>{{ __('Overzicht van alle tickets gekocht via Stripe voor uw organisatie.') }}</flux:subheading>
        </div>
    </div>

    <flux:card class="overflow-hidden">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>{{ __('Bestelnummer') }}</flux:table.column>
                <flux:table.column>{{ __('Klant') }}</flux:table.column>
                <flux:table.column>{{ __('Evenement') }}</flux:table.column>
                <flux:table.column>{{ __('Stripe Betalings-ID') }}</flux:table.column>
                <flux:table.column class="text-center">{{ __('Aantal tickets') }}</flux:table.column>
                <flux:table.column>{{ __('Bedrag') }}</flux:table.column>
                <flux:table.column>{{ __('Status') }}</flux:table.column>
                <flux:table.column>{{ __('Datum') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($orders as $order)
                    <flux:table.row :key="$order->id">
                        <flux:table.cell class="font-medium text-zinc-900 dark:text-zinc-100">
                            #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                        </flux:table.cell>
                        <flux:table.cell>
                            <div>
                                <div class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $order->user?->name ?? 'Gast Koper' }}</div>
                                <div class="text-xs text-zinc-500">{{ $order->user?->email ?? '-' }}</div>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell class="text-zinc-700 dark:text-zinc-300">
                            {{ $order->event?->title ?? __('Onbekend Evenement') }}
                        </flux:table.cell>
                        <flux:table.cell>
                            <span class="font-mono text-xs text-zinc-600 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded">
                                {{ $order->payment_id ?? 'N/A' }}
                            </span>
                        </flux:table.cell>
                        <flux:table.cell class="text-center font-semibold text-zinc-700 dark:text-zinc-300">
                            {{ $order->tickets->count() }}
                        </flux:table.cell>
                        <flux:table.cell class="font-semibold text-zinc-900 dark:text-zinc-100">
                            €{{ number_format($order->total_cents / 100, 2, ',', '.') }}
                        </flux:table.cell>
                        <flux:table.cell>
                            @if($order->status === 'paid')
                                <flux:badge size="sm" color="green" inset="top bottom">{{ __('Betaald') }}</flux:badge>
                            @elseif($order->status === 'pending')
                                <flux:badge size="sm" color="amber" inset="top bottom">{{ __('In afwachting') }}</flux:badge>
                            @else
                                <flux:badge size="sm" color="red" inset="top bottom">{{ $order->status }}</flux:badge>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell class="text-zinc-500 text-sm">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="8" class="text-center text-zinc-500 py-8">
                            {{ __('Geen bestellingen gevonden voor uw organisatie.') }}
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
