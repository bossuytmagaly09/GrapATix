<div class="bg-[#001E2B] min-h-screen text-white font-sans selection:bg-[#00ED64]/30 py-24 px-6 md:px-12 flex items-center justify-center">
    <div class="max-w-xl w-full bg-[#081621] border border-white/5 rounded-[32px] p-8 md:p-12 shadow-2xl relative overflow-hidden">
        
        <!-- Glowing Ambient light -->
        <div class="absolute -top-24 -left-24 w-48 h-48 bg-[#00ED64]/10 rounded-full blur-[80px]"></div>
        <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-[#00684A]/20 rounded-full blur-[80px]"></div>

        @if($error)
            <!-- Error State -->
            <div class="text-center space-y-6 relative z-10">
                <div class="size-20 bg-red-500/10 border border-red-500/20 text-red-500 rounded-full flex items-center justify-center mx-auto">
                    <flux:icon icon="x-mark" class="size-10" />
                </div>
                <h1 class="text-[32px] font-black tracking-tight text-white uppercase">Oeps! Er ging iets mis</h1>
                <p class="text-[#98A1A8] leading-relaxed">{{ $error }}</p>
                <div class="pt-6">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-white/5 hover:bg-white/10 text-white px-6 py-3 rounded-xl font-bold transition-all border border-white/10">
                        <flux:icon icon="arrow-left" class="size-4" />
                        Terug naar Home
                    </a>
                </div>
            </div>
        @else
            @if($order && $order->status !== 'paid')
                <!-- Processing State -->
                <div class="space-y-8 relative z-10" wire:poll.3s="checkStatus">
                    <div class="text-center space-y-4">
                        <div class="size-20 bg-blue-500/10 border border-blue-500/20 text-blue-500 rounded-full flex items-center justify-center mx-auto relative">
                            <span class="animate-spin absolute inline-flex h-full w-full rounded-full border-2 border-t-blue-500 border-r-transparent border-b-transparent border-l-transparent opacity-75"></span>
                            <flux:icon icon="clock" class="size-10" />
                        </div>
                        <h1 class="text-[32px] md:text-[36px] font-black tracking-tight text-white uppercase">Betaling Ontvangen</h1>
                        <p class="text-[#98A1A8] text-[15px]">We verwerken je tickets op de achtergrond. Dit duurt meestal maar een paar seconden. Even geduld...</p>
                    </div>
                </div>
            @else
                <!-- Success State -->
                <div class="space-y-8 relative z-10">
                    
                    <!-- Header Icon & Title -->
                    <div class="text-center space-y-4">
                        <div class="size-20 bg-[#00ED64]/10 border border-[#00ED64]/20 text-[#00ED64] rounded-full flex items-center justify-center mx-auto relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#00ED64]/5 opacity-75"></span>
                            <flux:icon icon="check" class="size-10" />
                        </div>
                        <h1 class="text-[32px] md:text-[36px] font-black tracking-tight text-[#00ED64] uppercase">Betaling Geslaagd!</h1>
                        <p class="text-[#98A1A8] text-[15px]">Bedankt voor je aankoop. Je tickets zijn succesvol gegenereerd.</p>
                    </div>

                    <!-- Event Details Card -->
                    <div class="bg-[#001E2B] rounded-2xl border border-white/5 p-6 space-y-4">
                        <div>
                            <span class="text-[11px] uppercase tracking-widest text-[#00ED64] font-bold">Jouw Event</span>
                            <h2 class="text-[20px] font-bold leading-tight mt-1">{{ $order->event->title }}</h2>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 text-[13px] text-[#98A1A8] border-t border-white/5 pt-4">
                            <div class="flex items-center gap-2">
                                <flux:icon icon="calendar" class="size-4 text-[#00ED64]" />
                                <span>{{ $order->event->start_date?->format('d M Y') }} @ {{ $order->event->start_date?->format('H:i') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <flux:icon icon="map-pin" class="size-4 text-[#00ED64]" />
                                <span>{{ $order->event->venue ? $order->event->venue->name : 'Locatie' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tickets info -->
                    <div class="space-y-4">
                        <h3 class="text-[14px] uppercase tracking-wider text-[#98A1A8] font-bold">Gegenereerde Tickets ({{ $ticketCount }})</h3>
                        
                        <!-- Ticket list -->
                        <div class="space-y-3 max-h-[220px] overflow-y-auto pr-1 custom-scrollbar">
                            @if($order && $order->tickets)
                                @foreach($order->tickets as $index => $ticket)
                                    <a href="{{ route('tickets.show', $ticket->id) }}" target="_blank" class="block">
                                        <div class="flex items-center justify-between bg-[#001E2B]/50 border border-white/5 rounded-xl p-4 group hover:border-[#00ED64]/30 transition-all cursor-pointer">
                                            <div class="flex items-center gap-3">
                                                <div class="size-10 rounded-lg bg-[#00ED64]/10 text-[#00ED64] flex items-center justify-center font-bold">
                                                    {{ $index + 1 }}
                                                </div>
                                                <div>
                                                    <p class="text-[14px] font-bold text-white group-hover:text-[#00ED64] transition-colors">{{ $ticket->ticketType->name ?? 'Standaard Entry' }}</p>
                                                    <p class="text-[11px] text-[#5C6C75] uppercase font-mono tracking-wider">GTX-{{ strtoupper(substr(md5($ticket->id), 0, 10)) }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2 text-[#00ED64] text-[12px] font-bold">
                                                <flux:icon icon="ticket" class="size-4" />
                                                <span>Gereed</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- CTA Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="{{ route('events.show', $order->event->slug) }}" class="flex-1 bg-[#00ED64] text-[#001E2B] py-3.5 rounded-xl font-bold text-[16px] hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                            <span>Event Details</span>
                            <flux:icon icon="arrow-right" class="size-4" />
                        </a>
                        <a href="{{ route('home') }}" class="flex-1 bg-white/5 hover:bg-white/10 text-white py-3.5 rounded-xl font-bold text-[16px] border border-white/10 hover:border-white/20 transition-all flex items-center justify-center gap-2">
                            <flux:icon icon="home" class="size-4" />
                            <span>Naar Home</span>
                        </a>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>

<style>
    /* Styling to make the scrollbar elegant and matching the design */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.02);
        border-radius: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(0, 237, 100, 0.2);
        border-radius: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(0, 237, 100, 0.4);
    }
</style>
