<div class="bg-[#001E2B] min-h-screen text-white font-sans">
    <!-- Header -->
    <header class="px-6 md:px-12 pt-12 md:pt-24 pb-8 md:pb-16">
        <div class="max-w-4xl">
            <h1 class="text-[42px] md:text-[92px] font-medium leading-[1] md:leading-[0.9] tracking-[-1px] md:tracking-[-3px] mb-4 md:mb-8">
                {{ $category->name }}
            </h1>
            <p class="text-[18px] md:text-[20px] text-[#98A1A8] max-w-2xl">
                Ontdek de beste events in de categorie {{ strtolower($category->name) }}.
            </p>
        </div>
    </header>

    <!-- Filters & Grid -->
    <div class="px-6 md:px-12 pb-32">
        <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center mb-8 md:mb-12 gap-6 md:gap-8">
            <div class="flex flex-wrap items-center gap-2 md:gap-4">
                <button 
                    wire:click="$set('dateFilter', 'all')"
                    class="px-4 md:px-6 py-2 rounded-full text-[12px] md:text-[14px] font-bold transition-all {{ $dateFilter === 'all' ? 'bg-[#00ED64] text-[#001E2B]' : 'bg-[#081621] text-[#98A1A8] hover:bg-white/10' }}"
                >
                    Alle
                </button>
                <button 
                    wire:click="$set('dateFilter', 'today')"
                    class="px-4 md:px-6 py-2 rounded-full text-[12px] md:text-[14px] font-bold transition-all {{ $dateFilter === 'today' ? 'bg-[#00ED64] text-[#001E2B]' : 'bg-[#081621] text-[#98A1A8] hover:bg-white/10' }}"
                >
                    Vandaag
                </button>
                <button 
                    wire:click="$set('dateFilter', 'tomorrow')"
                    class="px-4 md:px-6 py-2 rounded-full text-[12px] md:text-[14px] font-bold transition-all {{ $dateFilter === 'tomorrow' ? 'bg-[#00ED64] text-[#001E2B]' : 'bg-[#081621] text-[#98A1A8] hover:bg-white/10' }}"
                >
                    Morgen
                </button>
                <button 
                    wire:click="$set('dateFilter', 'weekend')"
                    class="px-4 md:px-6 py-2 rounded-full text-[12px] md:text-[14px] font-bold transition-all {{ $dateFilter === 'weekend' ? 'bg-[#00ED64] text-[#001E2B]' : 'bg-[#081621] text-[#98A1A8] hover:bg-white/10' }}"
                >
                    Weekend
                </button>
            </div>

            <div class="flex items-center gap-4 md:gap-8 w-full xl:w-auto">
                <div class="relative w-full xl:w-80">
                    <flux:icon icon="magnifying-glass" class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-[#5C6C75]" />
                    <input 
                        wire:model.live="search"
                        type="text" 
                        placeholder="Zoek..." 
                        class="w-full bg-[#081621] border border-white/5 rounded-full py-3 pl-12 pr-6 text-white focus:border-[#00ED64] focus:ring-0 transition-all text-[14px]"
                    >
                </div>
                
                <div class="hidden md:block text-[14px] text-[#98A1A8] whitespace-nowrap">
                    <span class="text-white font-bold">{{ $events->count() }}</span> gevonden
                </div>
            </div>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($events as $event)
                <div class="group bg-[#081621] border border-white/5 rounded-[20px] overflow-hidden hover:border-[#00ED64]/50 transition-all duration-300">
                    <a href="{{ route('events.show', $event->slug) }}" class="block relative h-64 overflow-hidden">
                        @if($url = $event->getFirstMediaUrl('cover'))
                            <img src="{{ $url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-[#00684A] to-[#001E2B] flex items-center justify-center">
                                <span class="text-white/20 font-bold text-3xl">GrapATix</span>
                            </div>
                        @endif
                        <div class="absolute top-4 right-4 bg-[#00ED64] text-[#001E2B] px-3 py-1 rounded-md font-bold text-[12px]">
                            €{{ number_format($event->price_cents / 100, 2, ',', '.') }}
                        </div>
                    </a>

                    <div class="p-8">
                        <h3 class="text-[24px] font-medium mb-2 group-hover:text-[#00ED64] transition-colors">
                            <a href="{{ route('events.show', $event->slug) }}">{{ $event->title }}</a>
                        </h3>
                        <div class="flex items-center gap-2 text-[#98A1A8] text-[14px] mb-8">
                            <flux:icon icon="calendar" class="size-4" />
                            <span>{{ $event->start_date?->format('d M Y') }}</span>
                        </div>
                        
                        <a href="{{ route('events.show', $event->slug) }}" class="inline-flex items-center gap-2 text-[#00ED64] font-bold text-[14px] group/btn">
                            Bekijk Details
                            <flux:icon icon="arrow-right" class="size-4 group-hover/btn:translate-x-1 transition-transform" />
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 text-center bg-[#081621] rounded-[32px] border border-dashed border-white/10">
                    <flux:icon icon="calendar" class="size-16 text-[#5C6C75] mx-auto mb-6" />
                    <h3 class="text-[24px] font-medium mb-2">Geen events gevonden</h3>
                    <p class="text-[#98A1A8]">Probeer een andere zoekterm of kijk bij een andere categorie.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
