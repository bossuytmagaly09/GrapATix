<div class="bg-[#001E2B] min-h-screen text-white font-sans">
    <!-- Header / Cover -->
    <div class="relative h-[50vh] md:h-[60vh] overflow-hidden">
        @if($url = $event->getFirstMediaUrl('cover'))
            <img src="{{ $url }}" class="w-full h-full object-cover opacity-60">
        @else
            <div class="w-full h-full bg-gradient-to-br from-[#00684A] to-[#001E2B] opacity-60"></div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-[#001E2B] via-[#001E2B]/20 to-transparent"></div>
        
        <div class="absolute bottom-12 px-6 md:px-12 w-full">
            <div class="max-w-4xl">
                <span class="bg-[#00ED64] text-[#001E2B] px-3 py-1 rounded-full text-[12px] font-bold uppercase tracking-wider mb-4 md:mb-6 inline-block">
                    {{ $event->category?->name ?? 'Event' }}
                </span>
                <h1 class="text-[36px] md:text-[82px] font-medium leading-[1] tracking-[-1px] md:tracking-[-3px] mb-6">
                    {{ $event->title }}
                </h1>
                <div class="flex flex-col md:flex-row flex-wrap gap-4 md:gap-8 text-[14px] md:text-[16px] text-[#98A1A8]">
                    <div class="flex items-center gap-3">
                        <flux:icon icon="calendar" class="size-5 text-[#00ED64]" />
                        <span>{{ $event->start_date?->format('d M Y') }} @ {{ $event->start_date?->format('H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <flux:icon icon="map-pin" class="size-5 text-[#00ED64]" />
                        <span>{{ $event->venue ? $event->venue->name : 'Locatie nog onbekend' }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <flux:icon icon="ticket" class="size-5 text-[#00ED64]" />
                        <span class="text-white font-bold">
                            @if(count($ticketTypes) > 0)
                                Vanaf €{{ number_format($ticketTypes->min('price_cents') / 100, 2, ',', '.') }}
                            @else
                                Gratis
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="px-6 md:px-12 py-12 md:py-24">
        <div class="grid grid-cols-12 gap-8 md:gap-16">
            <!-- Left: Description -->
            <div class="col-span-12 lg:col-span-8 space-y-12">
                <div class="prose prose-invert prose-lg max-w-none">
                    <h2 class="text-[28px] md:text-[32px] font-medium text-white mb-6 md:mb-8">Over dit event</h2>
                    <div class="text-[#98A1A8] leading-relaxed">
                        {!! $event->description !!}
                    </div>
                </div>

                <div class="pt-12 border-t border-white/5 flex gap-4">
                    <span class="text-[14px] text-[#5C6C75]">Tags:</span>
                    <span class="text-[14px] text-[#00ED64]">#Tech</span>
                    <span class="text-[14px] text-[#00ED64]">#{{ $event->category?->name }}</span>
                </div>
            </div>

            <!-- Right: Sidebar / Tickets -->
            <div class="col-span-12 lg:col-span-4">
                <div class="sticky top-32 p-8 rounded-[24px] bg-[#081621] border border-white/5 space-y-8 mb-24 lg:mb-0">
                    @php
                        $globalRemaining = $ticketTypes->sum(function($type) {
                            return max(0, $type->available_quantity - $type->tickets_count);
                        });
                    @endphp
                    <div>
                        <h4 class="text-[14px] uppercase tracking-widest text-[#98A1A8] mb-2">Status</h4>
                        <div class="flex items-center gap-2 {{ $globalRemaining > 0 ? 'text-[#00ED64]' : 'text-red-500' }} font-bold">
                            @if($globalRemaining > 0)
                                <span class="relative flex h-3 w-3">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#00ED64] opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-[#00ED64]"></span>
                                </span>
                                Nog {{ $globalRemaining }} Tickets Beschikbaar
                            @else
                                <span class="relative flex h-3 w-3">
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                </span>
                                Volledig Uitverkocht
                            @endif
                        </div>
                    </div>

                    <!-- Ticket Types Loop -->
                    <div class="space-y-4 pt-4 border-t border-white/5">
                        @php
                            $totalCents = 0;
                            $totalQty = 0;
                            foreach($ticketTypes as $type) {
                                $q = $quantities[$type->id] ?? 0;
                                $totalCents += $type->price_cents * $q;
                                $totalQty += $q;
                            }
                        @endphp
                        
                        @forelse($ticketTypes as $type)
                            @php
                                $remaining = max(0, $type->available_quantity - $type->tickets_count);
                            @endphp
                            <div class="flex flex-col gap-2">
                                <div class="flex justify-between items-center text-[14px]">
                                    <div class="flex flex-col">
                                        <span class="text-[#98A1A8] font-semibold">{{ $type->name }}</span>
                                        <span class="text-[12px] {{ $remaining <= 20 ? 'text-orange-400 font-bold' : 'text-[#5C6C75]' }}">
                                            @if($remaining > 0)
                                                Nog {{ $remaining }} beschikbaar
                                            @else
                                                <span class="text-red-500 font-bold">Uitverkocht</span>
                                            @endif
                                        </span>
                                    </div>
                                    <span class="text-white font-bold">€{{ number_format($type->price_cents / 100, 2, ',', '.') }}</span>
                                </div>
                                <div class="flex items-center justify-between bg-[#001E2B] rounded-xl border border-white/10 p-2 {{ $remaining === 0 ? 'opacity-50 pointer-events-none' : '' }}">
                                    <button wire:click="decrementQuantity({{ $type->id }})" class="size-9 rounded-lg bg-white/5 hover:bg-white/10 text-white flex items-center justify-center font-bold transition-colors disabled:opacity-30 disabled:pointer-events-none" {{ ($quantities[$type->id] ?? 0) <= 0 ? 'disabled' : '' }}>
                                        -
                                    </button>
                                    <span class="text-[18px] font-medium px-4 text-white">{{ $quantities[$type->id] ?? 0 }}</span>
                                    <button wire:click="incrementQuantity({{ $type->id }})" class="size-9 rounded-lg bg-white/5 hover:bg-white/10 text-white flex items-center justify-center font-bold transition-colors disabled:opacity-30 disabled:pointer-events-none" {{ ($quantities[$type->id] ?? 0) >= 10 || ($quantities[$type->id] ?? 0) >= $remaining ? 'disabled' : '' }}>
                                        +
                                    </button>
                                </div>
                            </div>
                        @empty
                            <p class="text-white/50 text-sm">Geen tickets beschikbaar op dit moment.</p>
                        @endforelse
                    </div>

                    <!-- Dynamic Price Display -->
                    <div class="flex justify-between items-center border-t border-white/5 pt-4">
                        <span class="text-[#98A1A8]">Totaal</span>
                        <span class="text-[24px] font-black text-[#00ED64]">
                            €{{ number_format($totalCents / 100, 2, ',', '.') }}
                        </span>
                    </div>

                    <button wire:click="buyTickets" wire:loading.attr="disabled" class="w-full bg-[#00ED64] text-[#001E2B] py-4 rounded-[12px] font-bold text-[18px] hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3 disabled:opacity-50 disabled:pointer-events-none" {{ $totalQty === 0 ? 'disabled' : '' }}>
                        <span wire:loading.remove wire:target="buyTickets">Bestel Tickets</span>
                        <span wire:loading wire:target="buyTickets" class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-[#001E2B]" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Naar Stripe...
                        </span>
                        <flux:icon icon="arrow-right" class="size-5" />
                    </button>

                    <p class="text-[12px] text-[#5C6C75] text-center">
                        Veilig betalen via Bancontact, iDEAL of Creditcard.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Sticky CTA -->
    <div class="lg:hidden fixed bottom-0 left-0 w-full p-4 bg-[#001E2B]/95 backdrop-blur-md border-t border-white/5 z-40">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-[11px] text-[#98A1A8]">Totaal ({{ $totalQty }}x)</p>
                <p class="text-[18px] font-bold text-[#00ED64]">€{{ number_format($totalCents / 100, 2, ',', '.') }}</p>
            </div>

            <button wire:click="buyTickets" wire:loading.attr="disabled" class="flex-1 bg-[#00ED64] text-[#001E2B] py-3 rounded-xl font-bold flex items-center justify-center gap-2 disabled:opacity-50" {{ $totalQty === 0 ? 'disabled' : '' }}>
                <span wire:loading.remove wire:target="buyTickets">Bestel</span>
                <span wire:loading wire:target="buyTickets" class="flex items-center gap-1.5">
                    <svg class="animate-spin h-4 w-4 text-[#001E2B]" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Stripe...
                </span>
                <flux:icon icon="arrow-right" class="size-4" />
            </button>
        </div>
    </div>
</div>
