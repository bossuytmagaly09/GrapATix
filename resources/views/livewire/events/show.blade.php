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
                        <span class="text-white font-bold">€{{ number_format($event->price_cents / 100, 2, ',', '.') }}</span>
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

            <!-- Right: Sidebar / Sticky CTA (Desktop) -->
            <div class="hidden lg:block lg:col-span-4">
                <div class="sticky top-32 p-8 rounded-[24px] bg-[#081621] border border-white/5 space-y-8">
                    <div>
                        <h4 class="text-[14px] uppercase tracking-widest text-[#98A1A8] mb-2">Status</h4>
                        <div class="flex items-center gap-2 text-[#00ED64] font-bold">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#00ED64] opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-[#00ED64]"></span>
                            </span>
                            Tickets Beschikbaar
                        </div>
                    </div>

                    <button class="w-full bg-[#00ED64] text-[#001E2B] py-4 rounded-[12px] font-bold text-[18px] hover:scale-[1.02] transition-transform flex items-center justify-center gap-3">
                        Bestel Tickets
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
                <p class="text-[12px] text-[#98A1A8]">Vanaf</p>
                <p class="text-[20px] font-bold text-white">€{{ number_format($event->price_cents / 100, 2, ',', '.') }}</p>
            </div>
            <button class="flex-1 bg-[#00ED64] text-[#001E2B] py-3 rounded-xl font-bold flex items-center justify-center gap-2">
                Tickets
                <flux:icon icon="arrow-right" class="size-4" />
            </button>
        </div>
    </div>
</div>
