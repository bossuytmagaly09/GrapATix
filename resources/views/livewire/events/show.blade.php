<div class="bg-[#001E2B] text-white font-sans">
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
    <div class="px-6 md:px-12 pt-12 pb-16 md:pt-24 md:pb-24">
        <div class="grid grid-cols-12 gap-8 md:gap-16">
            <!-- Left: Description -->
            <div class="col-span-12 lg:col-span-8 space-y-12">
                <div class="prose prose-invert prose-lg max-w-none">
                    <h2 class="text-[28px] md:text-[32px] font-medium text-white mb-6 md:mb-8">Over dit event</h2>
                    <div class="text-[#98A1A8] leading-relaxed">
                        {!! $event->description !!}
                    </div>
                </div>

                @if(is_array($event->schedule) && count($event->schedule) > 0)
                <!-- Programma / Tijdschema -->
                <div class="pt-12 border-t border-white/5 space-y-8">
                    <h2 class="text-[28px] md:text-[32px] font-black uppercase tracking-tight text-white">
                        Programma / <span class="text-[#00ED64]">Tijdschema</span>
                    </h2>
                    
                    <div class="relative pl-6 border-l border-[#00ED64]/30 space-y-8">
                        @foreach($event->schedule as $item)
                        <!-- Timeline Item -->
                        <div class="relative">
                            <span class="absolute -left-[30px] top-1.5 size-4 rounded-full bg-[#00ED64] border-4 border-[#001E2B] shadow-[0_0_8px_#00ED64]"></span>
                            <div class="space-y-1">
                                <span class="text-[12px] font-bold text-[#00ED64] uppercase tracking-wider bg-[#00ED64]/10 border border-[#00ED64]/20 px-2.5 py-0.5 rounded-full">{{ $item['time'] ?? '' }}</span>
                                <h4 class="text-lg font-bold text-white">{{ $item['title'] ?? '' }}</h4>
                                @if(!empty($item['description']))
                                    <p class="text-[#98A1A8] text-sm leading-relaxed">{{ $item['description'] }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Locatie & Organisatie -->
                <div class="pt-12 border-t border-white/5 space-y-8">
                    <h2 class="text-[28px] md:text-[32px] font-black uppercase tracking-tight text-white">
                        Organisatie & <span class="text-[#00ED64]">Locatie</span>
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Host Card -->
                        <div class="bg-[#081621] border border-white/5 rounded-3xl p-6 md:p-8 space-y-6 flex flex-col justify-between">
                            <div class="space-y-4">
                                <span class="text-[10px] text-[#98A1A8] font-bold uppercase tracking-wider bg-white/5 border border-white/10 px-2.5 py-1 rounded-lg inline-flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#00ED64] animate-pulse"></span>
                                    Host/Organisator
                                </span>
                                <div class="space-y-2">
                                    <h3 class="text-2xl font-black uppercase text-white tracking-tight leading-tight flex items-center gap-2">
                                        {{ $event->organization->name }}
                                        <flux:icon icon="check-badge" class="size-6 text-[#00ED64] shrink-0" title="Geverifieerde organisator" />
                                    </h3>
                                    <p class="text-[#98A1A8] text-xs leading-relaxed">
                                        Geverifieerde organisator op het GrapATix platform. Toegewijd aan het leveren van veilige, naadloze en grensverleggende evenementen voor de tech community.
                                    </p>
                                </div>
                            </div>
                            <div class="pt-4 border-t border-white/5 flex items-center justify-between">
                                <span class="text-[11px] text-[#5C6C75] font-bold uppercase tracking-wider">Actief op platform</span>
                                <span class="text-[12px] text-[#00ED64] font-bold">100% Betrouwbaar</span>
                            </div>
                        </div>

                        <!-- Venue Card with Interactive Mock Map -->
                        <div class="bg-[#081621] border border-white/5 rounded-3xl p-6 md:p-8 space-y-6 flex flex-col justify-between">
                            <div class="space-y-4">
                                <span class="text-[10px] text-[#98A1A8] font-bold uppercase tracking-wider bg-white/5 border border-white/10 px-2.5 py-1 rounded-lg inline-flex items-center gap-1.5">
                                    <flux:icon icon="map-pin" class="size-3.5 text-[#00ED64]" />
                                    Locatie Details
                                </span>
                                <div class="space-y-2">
                                    <h3 class="text-2xl font-black uppercase text-white tracking-tight leading-tight">
                                        {{ $event->venue ? $event->venue->name : 'Locatie nog onbekend' }}
                                    </h3>
                                    <p class="text-[#98A1A8] text-xs leading-relaxed">
                                        {{ $event->venue ? $event->venue->address : 'Adres volgt binnenkort.' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Mock Map Widget -->
                            <div class="relative w-full h-32 rounded-2xl overflow-hidden border border-white/10 bg-[#001E2B] flex items-center justify-center group/map">
                                <!-- Abstract Cyberpunk Map lines using SVG/CSS -->
                                <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#00ED64_1px,transparent_1px)] [background-size:16px_16px]"></div>
                                <div class="absolute w-[150%] h-[1px] bg-[#00ED64]/10 rotate-12"></div>
                                <div class="absolute w-[150%] h-[1px] bg-[#00ED64]/10 -rotate-45"></div>
                                <div class="absolute w-[1px] h-[150%] bg-[#00ED64]/10 left-1/3"></div>
                                <div class="absolute w-[1px] h-[150%] bg-[#00ED64]/10 left-2/3"></div>

                                <!-- Central glowing neon marker -->
                                <div class="relative z-10 flex flex-col items-center gap-1">
                                    <span class="relative flex h-4 w-4">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#00ED64] opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-4 w-4 bg-[#00ED64] shadow-[0_0_10px_#00ED64] flex items-center justify-center">
                                            <span class="w-1.5 h-1.5 bg-[#001E2B] rounded-full"></span>
                                        </span>
                                    </span>
                                </div>

                                <a href="https://maps.google.com/?q={{ urlencode(($event->venue?->name ?? '') . ' ' . ($event->venue?->address ?? '')) }}" target="_blank" class="absolute bottom-2 right-2 bg-[#001E2B]/85 backdrop-blur-md border border-white/10 hover:border-[#00ED64]/40 px-3 py-1 rounded-xl text-[10px] text-white hover:text-[#00ED64] font-bold uppercase tracking-wider transition-all z-20">
                                    Google Maps
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Accordion -->
                <div class="pt-12 border-t border-white/5 space-y-8">
                    <h2 class="text-[28px] md:text-[32px] font-black uppercase tracking-tight text-white">
                        Veelgestelde <span class="text-[#00ED64]">Vragen</span>
                    </h2>
                    
                    <div x-data="{ activeFaq: null }" class="space-y-4">
                        <!-- FAQ Item 1 -->
                        <div class="bg-[#081621] border border-white/5 rounded-2xl overflow-hidden transition-all duration-300" :class="activeFaq === 1 ? 'border-[#00ED64]/20 shadow-lg' : ''">
                            <button type="button" @click="activeFaq = activeFaq === 1 ? null : 1" class="w-full px-6 py-4 flex justify-between items-center text-left hover:text-[#00ED64] transition-colors focus:outline-none">
                                <span class="font-bold text-[15px] text-white">Hoe en wanneer ontvang ik mijn tickets?</span>
                                <flux:icon icon="chevron-down" class="size-4 text-[#98A1A8] transition-transform duration-300" ::class="activeFaq === 1 ? 'rotate-180 text-[#00ED64]' : ''" />
                            </button>
                            <div x-show="activeFaq === 1" x-collapse class="px-6 pb-5 text-[#98A1A8] text-sm leading-relaxed border-t border-white/5 pt-3">
                                Direct nadat je betaling via Stripe succesvol is afgerond, worden de tickets direct in onze database gegenereerd. Je ontvangt direct een e-mailbevestiging met je QR-tickets in de bijlage. Daarnaast zijn je tickets altijd direct online te bekijken en te openen onder "Mijn Tickets" in het menu.
                            </div>
                        </div>

                        <!-- FAQ Item 2 -->
                        <div class="bg-[#081621] border border-white/5 rounded-2xl overflow-hidden transition-all duration-300" :class="activeFaq === 2 ? 'border-[#00ED64]/20 shadow-lg' : ''">
                            <button type="button" @click="activeFaq = activeFaq === 2 ? null : 2" class="w-full px-6 py-4 flex justify-between items-center text-left hover:text-[#00ED64] transition-colors focus:outline-none">
                                <span class="font-bold text-[15px] text-white">Kan ik mijn gekochte tickets annuleren of overdragen?</span>
                                <flux:icon icon="chevron-down" class="size-4 text-[#98A1A8] transition-transform duration-300" ::class="activeFaq === 2 ? 'rotate-180 text-[#00ED64]' : ''" />
                            </button>
                            <div x-show="activeFaq === 2" x-collapse class="px-6 pb-5 text-[#98A1A8] text-sm leading-relaxed border-t border-white/5 pt-3">
                                Aangekochte tickets zijn in principe definitief en kunnen niet worden geretourneerd of geannuleerd. Echter, de tickets zijn niet strikt persoonsgebonden. Je kunt de QR-code of de ticket-URL gerust doorgeven aan een vriend of collega die in jouw plaats wil gaan. Een ticket kan slechts één keer succesvol gescand worden bij de entree.
                            </div>
                        </div>

                        <!-- FAQ Item 3 -->
                        <div class="bg-[#081621] border border-white/5 rounded-2xl overflow-hidden transition-all duration-300" :class="activeFaq === 3 ? 'border-[#00ED64]/20 shadow-lg' : ''">
                            <button type="button" @click="activeFaq = activeFaq === 3 ? null : 3" class="w-full px-6 py-4 flex justify-between items-center text-left hover:text-[#00ED64] transition-colors focus:outline-none">
                                <span class="font-bold text-[15px] text-white">Wat moet ik meenemen naar de ingang van het evenement?</span>
                                <flux:icon icon="chevron-down" class="size-4 text-[#98A1A8] transition-transform duration-300" ::class="activeFaq === 3 ? 'rotate-180 text-[#00ED64]' : ''" />
                            </button>
                            <div x-show="activeFaq === 3" x-collapse class="px-6 pb-5 text-[#98A1A8] text-sm leading-relaxed border-t border-white/5 pt-3">
                                Het enige wat je nodig hebt is een geldige QR-code van je ticket. Dit kan de geprinte versie zijn, de bijlage uit de mail, of rechtstreeks vanaf je smartphone via de "Mijn Tickets" pagina. Zorg ervoor dat het scherm van je telefoon helder is ingesteld bij de ingang, zodat onze poortwachters je ticket soepel en snel kunnen scannen.
                            </div>
                        </div>

                        <!-- FAQ Item 4 -->
                        <div class="bg-[#081621] border border-white/5 rounded-2xl overflow-hidden transition-all duration-300" :class="activeFaq === 4 ? 'border-[#00ED64]/20 shadow-lg' : ''">
                            <button type="button" @click="activeFaq = activeFaq === 4 ? null : 4" class="w-full px-6 py-4 flex justify-between items-center text-left hover:text-[#00ED64] transition-colors focus:outline-none">
                                <span class="font-bold text-[15px] text-white">Is de locatie goed bereikbaar en is er parkeergelegenheid?</span>
                                <flux:icon icon="chevron-down" class="size-4 text-[#98A1A8] transition-transform duration-300" ::class="activeFaq === 4 ? 'rotate-180 text-[#00ED64]' : ''" />
                            </button>
                            <div x-show="activeFaq === 4" x-collapse class="px-6 pb-5 text-[#98A1A8] text-sm leading-relaxed border-t border-white/5 pt-3">
                                Ja, al onze geselecteerde evenementenlocaties zijn goed bereikbaar per auto en openbaar vervoer. Details over parkeerplaatsen of specifieke ov-lijnen vind je via de Google Maps-knop in de locatiekaart hierboven. We raden aan om voor grote festivals en stadsconferenties gebruik te maken van het openbaar vervoer of de fiets.
                            </div>
                        </div>
                    </div>
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

    <!-- Related Events Section -->
    @if(count($relatedEvents) > 0)
    <div class="px-6 md:px-12 pb-16 md:pb-24">
        <div class="border-t border-white/5 pt-12 md:pt-16">
            <h2 class="text-[28px] md:text-[32px] font-black uppercase tracking-tight text-white mb-8">
                Andere evenementen die je <span class="text-[#00ED64]">misschien leuk vindt</span>
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($relatedEvents as $relEvent)
                    @php
                        $coverUrl = $relEvent->getFirstMediaUrl('cover');
                        if (!$coverUrl) {
                            $slug = $relEvent->category->slug ?? '';
                            if ($slug === 'festivals') {
                                $coverUrl = 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?q=80&w=800';
                            } elseif ($slug === 'sport') {
                                $coverUrl = 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?q=80&w=800';
                            } elseif ($slug === 'cultuur') {
                                $coverUrl = 'https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?q=80&w=800';
                            } elseif ($slug === 'beurzen') {
                                $coverUrl = 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=800';
                            } elseif ($slug === 'carmeeting') {
                                $coverUrl = 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?q=80&w=800';
                            } else {
                                $coverUrl = asset('images/placeholders/festival.png');
                            }
                        }
                    @endphp
                    <div class="group relative bg-[#081621] border border-white/5 rounded-[24px] overflow-hidden flex flex-col justify-between hover:border-[#00ED64]/35 hover:shadow-2xl hover:shadow-[#00ED64]/5 transition-all duration-300 transform hover:-translate-y-1">
                        <div>
                            <div class="relative aspect-[16/9] w-full overflow-hidden">
                                <img src="{{ $coverUrl }}" alt="{{ $relEvent->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 opacity-80 group-hover:opacity-100">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#081621] via-[#081621]/30 to-transparent"></div>
                                
                                <span class="absolute top-4 left-4 bg-[#001E2B]/80 backdrop-blur-md border border-white/10 text-[#00ED64] text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-xl shadow-lg">
                                    {{ $relEvent->category->name ?? 'Event' }}
                                </span>
                            </div>

                            <div class="p-5 space-y-3">
                                <div class="flex items-center gap-2 text-[11px] text-[#98A1A8] font-bold uppercase tracking-wider">
                                    <flux:icon icon="calendar" class="size-3.5 text-[#00ED64]" />
                                    <span>{{ $relEvent->start_date?->timezone('Europe/Brussels')->format('d M Y') }}</span>
                                </div>

                                <h3 class="text-lg font-bold leading-snug group-hover:text-[#00ED64] transition-colors duration-300">
                                    <a href="{{ route('events.show', $relEvent->slug) }}" class="focus:outline-none">
                                        <span class="absolute inset-0 z-10" aria-hidden="true"></span>
                                        {{ $relEvent->title }}
                                    </a>
                                </h3>

                                <p class="text-white/60 text-[12px] font-light leading-relaxed line-clamp-2">
                                    {{ $relEvent->description }}
                                </p>
                            </div>
                        </div>

                        <div class="p-5 border-t border-white/5 flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-[#98A1A8] font-medium uppercase tracking-wider">Tickets vanaf</span>
                                <span class="text-lg font-black text-white">
                                    €{{ number_format($relEvent->price_cents / 100, 2, ',', '.') }}
                                </span>
                            </div>
                            
                            <a href="{{ route('events.show', $relEvent->slug) }}" class="relative z-20 bg-[#00ED64]/10 hover:bg-[#00ED64] text-[#00ED64] hover:text-[#001E2B] px-5 py-2.5 rounded-2xl font-black text-[12px] uppercase tracking-wider border border-[#00ED64]/20 hover:border-transparent transition-all duration-300">
                                Tickets
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

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
