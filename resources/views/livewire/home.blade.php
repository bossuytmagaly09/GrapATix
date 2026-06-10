<div class="bg-[#001E2B] text-white font-sans selection:bg-[#00ED64]/30">
    
    @if($featuredEvent)
        <!-- Hero Banner (Ticketmaster Style) -->
        <header class="relative w-full min-h-[500px] md:h-[600px] flex items-center justify-start overflow-hidden bg-cover bg-center transition-all duration-700" style="background-image: url('{{ $featuredEvent->getFirstMediaUrl('cover') ?: ($featuredEvent->category->slug === 'festivals' ? 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=1600' : 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1600') }}');">
            <!-- Intense Dark Gradient Overlays for maximum contrast & beauty -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#001E2B] via-[#001E2B]/85 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#001E2B] via-transparent to-[#001E2B]/40"></div>

            <!-- Glowing background particle flare -->
            <div class="absolute right-0 top-0 w-[600px] h-[600px] rounded-full bg-[#00ED64] opacity-5 blur-[150px] pointer-events-none"></div>

            <div class="relative z-10 max-w-4xl px-6 md:px-12 py-16 md:py-24 text-left">
                <!-- HOT / FEATURED EVENT BADGE -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-[11px] font-black uppercase tracking-wider text-[#00ED64] mb-6 shadow-lg animate-pulse">
                    <span class="w-2 h-2 rounded-full bg-[#00ED64]"></span>
                    Hot Uitgelicht Event
                </div>

                <!-- EVENT TITLE -->
                <h1 class="text-4xl md:text-7xl font-black uppercase tracking-tight leading-[1.05] text-white mb-6 drop-shadow-xl select-none">
                    {{ $featuredEvent->title }}
                </h1>

                <!-- DESCRIPTION -->
                <p class="text-white/80 text-base md:text-lg font-light leading-relaxed max-w-2xl mb-8 drop-shadow-md">
                    {{ Str::limit($featuredEvent->description, 180) }}
                </p>

                <!-- META INFO (DATE, VENUE, MIN PRICE) -->
                <div class="flex flex-wrap items-center gap-y-3 gap-x-6 text-[13px] font-bold text-white/90 mb-10">
                    <!-- Date -->
                    <div class="flex items-center gap-2 px-4 py-2 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md">
                        <flux:icon icon="calendar" class="size-4.5 text-[#00ED64]" />
                        <span>{{ $featuredEvent->start_date?->timezone('Europe/Brussels')->format('d M Y') }} - {{ $featuredEvent->start_date?->timezone('Europe/Brussels')->format('H:i') }}</span>
                    </div>
                    <!-- Location -->
                    <div class="flex items-center gap-2 px-4 py-2 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md">
                        <flux:icon icon="map-pin" class="size-4.5 text-[#00ED64]" />
                        <span>{{ $featuredEvent->venue?->name ?? $featuredEvent->organization?->name }}</span>
                    </div>
                    <!-- Price starting from -->
                    <div class="flex items-center gap-2 px-4 py-2 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md">
                        <flux:icon icon="ticket" class="size-4.5 text-[#00ED64]" />
                        <span>Vanaf €{{ number_format($featuredEvent->price_cents / 100, 2, ',', '.') }}</span>
                    </div>
                </div>

                <!-- CTA BUTTON -->
                <a href="{{ route('events.show', $featuredEvent->slug) }}" class="inline-flex items-center gap-3 bg-[#00ED64] hover:bg-[#00D656] text-[#001E2B] font-black uppercase text-[13px] tracking-wider px-8 py-4.5 rounded-2xl shadow-lg hover:shadow-[#00ED64]/30 hover:scale-[1.03] transition-all duration-300 transform">
                    <span>Tickets Bestellen</span>
                    <flux:icon icon="arrow-right" class="size-4" />
                </a>
            </div>
        </header>
    @endif

    <div class="px-6 md:px-12 pb-16 space-y-12 md:space-y-16 overflow-x-hidden pt-8">
        
        @if($search)
            <!-- Active Search Query Badge -->
            <div class="flex items-center gap-2 pb-4">
                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-2xl bg-[#00ED64]/10 border border-[#00ED64]/20 text-[12px] font-bold text-[#00ED64] shadow-lg shadow-[#00ED64]/5">
                    <span>Zoekresultaat voor: "{{ $search }}"</span>
                    <button wire:click="resetFilters" class="hover:text-white transition-colors ml-1.5 focus:outline-none" title="Wis zoekopdracht">
                        <flux:icon icon="x-mark" class="size-4" />
                    </button>
                </div>
            </div>
        @endif

        <!-- Recent Added Section (Highlighted first!) -->
        <div class="space-y-6">
            <div class="flex items-center justify-between border-b border-white/5 pb-4">
                <h3 class="text-xl font-black uppercase tracking-tight text-[#00ED64]">Recent Toegevoegd</h3>
                <span class="text-[11px] text-[#98A1A8] font-bold uppercase tracking-wider">Altijd iets nieuws</span>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($recentEvents as $rEvent)
                    @php
                        $rCover = $rEvent->getFirstMediaUrl('cover');
                        if (!$rCover) {
                            $slug = $rEvent->category->slug ?? '';
                            if ($slug === 'festivals') {
                                $rCover = 'https://images.unsplash.com/photo-1533174072545-7a4b6ad7a6c3?q=80&w=400';
                            } elseif ($slug === 'sport') {
                                $rCover = 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?q=80&w=400';
                            } elseif ($slug === 'cultuur') {
                                $rCover = 'https://images.unsplash.com/photo-1460661419201-fd4cecdf8a8b?q=80&w=400';
                            } elseif ($slug === 'beurzen') {
                                $rCover = 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=400';
                            } elseif ($slug === 'carmeeting') {
                                $rCover = 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?q=80&w=400';
                            } else {
                                $rCover = asset('images/placeholders/festival.png');
                            }
                        }
                    @endphp
                    <a href="{{ route('events.show', $rEvent->slug) }}" class="relative rounded-[16px] overflow-hidden aspect-[4/3] group border border-white/5 hover:border-[#00ED64]/30 transition-all duration-300">
                        <img src="{{ $rCover }}" alt="{{ $rEvent->title }}" class="w-full h-full object-cover blur-[0.5px] opacity-40 group-hover:opacity-75 group-hover:blur-0 transition-all duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#081621] via-black/10 to-transparent"></div>
                        <div class="absolute inset-0 p-4 flex flex-col justify-end text-left">
                            <span class="text-[9px] text-[#00ED64] font-black uppercase tracking-wider mb-1">{{ $rEvent->category->name }}</span>
                            <span class="text-[12px] font-bold text-white group-hover:text-[#00ED64] transition-colors leading-tight truncate">
                                {{ $rEvent->title }}
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Dynamic Event Grid Section -->
        <div id="events-grid" class="space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                <div>
                    <h2 class="text-[28px] md:text-[32px] font-black uppercase tracking-tighter text-[#00ED64]">
                        @if($selectedCategory)
                            {{ $categories->firstWhere('slug', $selectedCategory)?->name }}
                        @else
                            Ontdek Events
                        @endif
                    </h2>
                    <p class="text-white/60 text-[13px]">Vind en boek tickets voor de leukste evenementen</p>
                </div>
                <span class="self-start sm:self-auto text-[12px] font-bold text-[#98A1A8] uppercase tracking-wider bg-white/5 px-3 py-1.5 rounded-xl border border-white/5 shrink-0">
                    {{ $events->count() }} event(s) gevonden
                </span>
            </div>

            @if($events->isEmpty())
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center py-20 px-6 rounded-[24px] bg-[#081621] border border-white/5 text-center">
                    <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center mb-6">
                        <flux:icon icon="ticket" class="size-8 text-white/40" />
                    </div>
                    <h3 class="text-xl font-bold mb-2">Geen evenementen gevonden</h3>
                    <p class="text-white/50 text-[14px] max-w-sm mb-6">Er zijn geen evenementen die voldoen aan je huidige zoekterm of categorie.</p>
                    <button wire:click="resetFilters" class="bg-white/10 hover:bg-white/15 text-white border border-white/10 px-5 py-2.5 rounded-2xl text-[13px] font-black uppercase tracking-wider transition-colors">
                        Filters Wissen
                    </button>
                </div>
            @else
                <!-- Events Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($events as $event)
                        @php
                            // Determine elegant cover image based on category
                            $coverUrl = $event->getFirstMediaUrl('cover');
                            if (!$coverUrl) {
                                $slug = $event->category->slug ?? '';
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
                                <!-- Cover Image container -->
                                <div class="relative aspect-[16/9] w-full overflow-hidden">
                                    <img src="{{ $coverUrl }}" alt="{{ $event->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 opacity-80 group-hover:opacity-100">
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#081621] via-[#081621]/30 to-transparent"></div>
                                    
                                    <!-- Category Badge inside cover -->
                                    <span class="absolute top-4 left-4 bg-[#001E2B]/80 backdrop-blur-md border border-white/10 text-[#00ED64] text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-xl shadow-lg">
                                        {{ $event->category->name }}
                                    </span>
                                </div>

                                <!-- Info Body -->
                                <div class="p-5 space-y-3">
                                    <div class="flex items-center gap-2 text-[11px] text-[#98A1A8] font-bold uppercase tracking-wider">
                                        <flux:icon icon="calendar" class="size-3.5 text-[#00ED64]" />
                                        <span>{{ $event->start_date?->timezone('Europe/Brussels')->format('d M Y') }}</span>
                                        <span class="mx-1">•</span>
                                        <span>{{ $event->start_date?->timezone('Europe/Brussels')->format('H:i') }}</span>
                                    </div>

                                    <h3 class="text-lg font-bold leading-snug group-hover:text-[#00ED64] transition-colors duration-300">
                                        <a href="{{ route('events.show', $event->slug) }}" class="focus:outline-none">
                                            <span class="absolute inset-0 z-10" aria-hidden="true"></span>
                                            {{ $event->title }}
                                        </a>
                                    </h3>

                                    <p class="text-white/60 text-[12px] font-light leading-relaxed line-clamp-2">
                                        {{ $event->description }}
                                    </p>
                                </div>
                            </div>

                            <!-- Footer section of card -->
                            <div class="p-5 border-t border-white/5 flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-[#98A1A8] font-medium uppercase tracking-wider">Tickets vanaf</span>
                                    <span class="text-lg font-black text-white">
                                        €{{ number_format($event->price_cents / 100, 2, ',', '.') }}
                                    </span>
                                </div>
                                
                                <a href="{{ route('events.show', $event->slug) }}" class="relative z-20 bg-[#00ED64]/10 hover:bg-[#00ED64] text-[#00ED64] hover:text-[#001E2B] px-5 py-2.5 rounded-2xl font-black text-[12px] uppercase tracking-wider border border-[#00ED64]/20 hover:border-transparent transition-all duration-300">
                                    Tickets
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

