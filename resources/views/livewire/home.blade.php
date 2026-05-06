<div class="bg-[#001E2B] min-h-screen text-white font-sans selection:bg-[#00ED64]/30">
    <!-- Hero Section -->
    <header class="relative pt-16 pb-24 px-12 overflow-hidden text-left">
        <div class="relative z-10">
            <h1 class="text-[72px] md:text-[110px] font-medium leading-[0.95] tracking-[-4px] mb-8">
                Een platform. <br><span class="text-[#00ED64]">Onbeperkte events.</span>
            </h1>
        </div>
    </header>

    <div class="px-12 pb-32 space-y-12">
        <!-- Main Grid Layout -->
        <div class="grid grid-cols-12 gap-10">
            
            <!-- Left: Featured Festivals (Col 5) -->
            <div class="col-span-12 lg:col-span-5 space-y-6">
                <h2 class="text-[24px] font-medium tracking-tight">Featured Festivals</h2>
                <div class="space-y-4">
                    @forelse($events->where('category.name', 'Festivals')->take(2) as $event)
                        <div class="group relative bg-[#081621] border border-white/5 rounded-[16px] overflow-hidden aspect-[16/9] hover:border-[#00ED64]/50 transition-all duration-300">
                            <img src="{{ $event->getFirstMediaUrl('cover') ?: asset('images/placeholders/festival.png') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 opacity-80 group-hover:opacity-100">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#001E2B] via-transparent to-transparent opacity-80"></div>
                            <div class="absolute bottom-6 left-6 right-6 flex justify-between items-end">
                                <div>
                                    <h3 class="text-[20px] font-medium mb-1">{{ $event->title }}</h3>
                                    <p class="text-white/60 text-[13px]">{{ $event->start_date?->format('j-M Y') }} - Amsterdam</p>
                                </div>
                                <button class="bg-[#00ED64] text-[#001E2B] px-4 py-1.5 rounded-lg font-bold text-[12px] group-hover:scale-105 transition-transform">Tickets</button>
                            </div>
                        </div>
                    @empty
                        <div class="group relative bg-[#081621] border border-white/5 rounded-[16px] overflow-hidden aspect-[16/9] hover:border-[#00ED64]/50 transition-all duration-300">
                            <img src="{{ asset('images/placeholders/festival.png') }}" class="w-full h-full object-cover opacity-60 group-hover:opacity-80 transition-opacity">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#001E2B] via-transparent to-transparent opacity-90"></div>
                            <div class="absolute bottom-6 left-6">
                                <h3 class="text-[22px] font-medium">Urban Sound Festival</h3>
                                <p class="text-white/50 text-[13px]">3-5 Juli 2026 - Amsterdam</p>
                            </div>
                            <button class="absolute bottom-6 right-6 bg-[#00ED64] text-[#001E2B] px-4 py-1.5 rounded-lg font-bold text-[12px]">Tickets</button>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Middle: Upcoming Expos (Col 4) -->
            <div class="col-span-12 lg:col-span-4 space-y-6">
                <h2 class="text-[20px] font-medium tracking-tight opacity-80">Upcoming Expos & Trade Fairs</h2>
                <div class="space-y-4">
                    @foreach(range(1, 3) as $i)
                        <div class="flex gap-4 p-4 rounded-[12px] bg-[#081621] border border-white/5 hover:border-[#00ED64]/30 hover:bg-[#00ED64]/5 transition-all group">
                            <div class="w-24 h-16 rounded-lg overflow-hidden bg-[#001E2B] shrink-0">
                                <img src="{{ asset('images/placeholders/expo.png') }}" class="w-full h-full object-cover grayscale opacity-50 group-hover:grayscale-0 group-hover:opacity-100 transition-all">
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-[14px] font-medium truncate group-hover:text-[#00ED64] transition-colors">Innovate Tech Expo {{ $i }}</h4>
                                <div class="flex items-center gap-2 mt-1 text-[11px] text-[#98A1A8]">
                                    <flux:icon icon="calendar" class="size-3" />
                                    <span>15-16 Aug 2026</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right: Conferences & More (Col 3) -->
            <div class="col-span-12 lg:col-span-3 space-y-6">
                <h2 class="text-[20px] font-medium tracking-tight opacity-80">Conferences & More</h2>
                <div class="grid gap-4">
                    <div class="p-6 rounded-[16px] bg-[#081621] border border-white/5 hover:border-[#00ED64]/40 hover:bg-[#00ED64]/5 transition-all group relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-30 group-hover:scale-110 transition-all">
                            <flux:icon icon="command-line" class="size-12 text-[#00ED64]" />
                        </div>
                        <h4 class="text-[18px] font-medium leading-tight group-hover:text-[#00ED64] transition-colors">Laravel Deep Dive</h4>
                        <div class="flex justify-between items-center mt-6">
                            <span class="text-[11px] text-[#98A1A8]">29 Jun 2026</span>
                            <button class="bg-[#00ED64]/10 text-[#00ED64] px-3 py-1 rounded-md font-bold text-[11px] border border-[#00ED64]/20 group-hover:bg-[#00ED64] group-hover:text-[#001E2B] transition-colors">Tickets</button>
                        </div>
                    </div>
                    <div class="p-6 rounded-[16px] bg-[#081621] border border-white/5 hover:border-[#00ED64]/40 hover:bg-[#00ED64]/5 transition-all group relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-30 group-hover:scale-110 transition-all">
                            <flux:icon icon="shield-check" class="size-12 text-[#00ED64]" />
                        </div>
                        <h4 class="text-[18px] font-medium leading-tight group-hover:text-[#00ED64] transition-colors">Cybersecurity Forum</h4>
                        <div class="flex justify-between items-center mt-6">
                            <span class="text-[11px] text-[#98A1A8]">27 Jun 2026</span>
                            <button class="bg-[#00ED64]/10 text-[#00ED64] px-3 py-1 rounded-md font-bold text-[11px] border border-[#00ED64]/20 group-hover:bg-[#00ED64] group-hover:text-[#001E2B] transition-colors">Tickets</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom Grid: Recent & Live Feed -->
        <div class="grid grid-cols-12 gap-8">
            <div class="col-span-12 lg:col-span-8">
                <div class="bg-[#081621] border border-white/5 rounded-[24px] p-8">
                    <h3 class="text-[18px] font-medium mb-6">Recent Toegevoegd</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach(range(1, 4) as $i)
                            <div class="relative rounded-[16px] overflow-hidden aspect-[4/3] group border border-white/5 hover:border-[#00ED64]/30 transition-all">
                                <img src="{{ asset('images/placeholders/festival.png') }}" class="w-full h-full object-cover blur-[1px] opacity-40 group-hover:opacity-70 group-hover:blur-0 transition-all">
                                <div class="absolute inset-0 bg-black/20 flex items-center justify-center p-4 text-center">
                                    <span class="text-[12px] font-medium group-hover:text-[#00ED64] transition-colors">Winter Wonderland Fair</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-4">
                <div class="bg-[#081621] border border-white/5 rounded-[24px] p-8 h-full">
                    <h3 class="text-[18px] font-medium mb-6">Live Feed</h3>
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 group">
                            <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center shrink-0 group-hover:bg-[#00ED64]/10 transition-colors">
                                <flux:icon icon="user" class="size-4 text-[#98A1A8] group-hover:text-[#00ED64]" />
                            </div>
                            <div class="text-[13px]">
                                <span class="font-medium text-[#00ED64]">Jan</span> kocht 2 tickets voor <span class="italic">Urban Sound</span>
                            </div>
                            <span class="ml-auto text-[11px] text-[#98A1A8]">10:05</span>
                        </div>
                        <div class="flex items-center gap-3 group">
                            <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center shrink-0 group-hover:bg-[#00ED64]/10 transition-colors">
                                <flux:icon icon="bolt" class="size-4 text-[#00ED64]" />
                            </div>
                            <div class="text-[13px]">
                                <span class="font-medium group-hover:text-[#00ED64] transition-colors">Nieuwe standhouder</span> voor Innovate Tech
                            </div>
                            <span class="ml-auto text-[11px] text-[#98A1A8]">18:03</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
