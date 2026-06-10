<div class="bg-[#001E2B] text-white pt-16 pb-16 px-6 md:px-12 relative overflow-hidden">
    <!-- Glowing Ambient lights -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-[#00ED64]/5 rounded-full blur-[150px]"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-[#00684A]/10 rounded-full blur-[150px]"></div>

    <div class="max-w-6xl mx-auto space-y-12 relative z-10">
        <!-- Header -->
        <div class="space-y-4">
            <h1 class="text-4xl md:text-5xl font-black tracking-tight text-white uppercase">
                Mijn <span class="text-[#00ED64]">Tickets</span>
            </h1>
            <p class="text-[#98A1A8] text-sm md:text-base max-w-xl">
                Hier vind je al jouw aangekochte tickets voor evenementen op GrapATix. Toon de QR-code bij de ingang om binnen te gaan.
            </p>
        </div>

        <!-- Tickets Grid -->
        @if($tickets->isEmpty())
            <div class="bg-[#081621] border border-white/5 rounded-[32px] p-12 text-center space-y-6 max-w-md mx-auto shadow-2xl relative overflow-hidden">
                <div class="size-16 bg-white/5 border border-white/10 rounded-2xl flex items-center justify-center mx-auto text-[#98A1A8]">
                    <flux:icon icon="ticket" class="size-8" />
                </div>
                <div class="space-y-2">
                    <h3 class="text-xl font-bold text-white">Nog geen tickets</h3>
                    <p class="text-[#98A1A8] text-xs">Je hebt momenteel geen actieve tickets. Koop een ticket voor een van onze evenementen om het hier te zien.</p>
                </div>
                <a href="/" class="inline-flex px-6 py-3 bg-[#00ED64] text-[#001E2B] rounded-xl text-xs font-black uppercase tracking-wider transition-all hover:scale-105 hover:shadow-lg hover:shadow-[#00ED64]/20 cursor-pointer">
                    Ontdek Evenementen
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($tickets as $ticket)
                    <div class="group bg-[#081621] border border-white/5 rounded-3xl overflow-hidden shadow-2xl transition-all duration-300 hover:border-[#00ED64]/20 hover:shadow-[#00ED64]/5 relative flex flex-col justify-between">
                        
                        <!-- Event details -->
                        <div class="p-6 md:p-8 space-y-6">
                            <div class="flex justify-between items-start">
                                <span class="px-2.5 py-1 bg-white/5 border border-white/10 rounded-lg text-[10px] font-bold text-[#00ED64] uppercase tracking-wider">
                                    {{ $ticket->event->category->name ?? 'Evenement' }}
                                </span>
                                <span class="flex items-center gap-1.5 text-[11px] font-bold {{ $ticket->status === 'scanned' ? 'text-[#98A1A8]' : 'text-[#00ED64]' }}">
                                    <span class="size-2 rounded-full {{ $ticket->status === 'scanned' ? 'bg-white/30' : 'bg-[#00ED64] animate-pulse' }}"></span>
                                    {{ $ticket->status === 'scanned' ? 'Reeds gescand' : 'Geldig ticket' }}
                                </span>
                            </div>

                            <div class="space-y-2">
                                <h3 class="text-xl md:text-2xl font-black uppercase text-white tracking-tight leading-tight group-hover:text-[#00ED64] transition-colors">
                                    {{ $ticket->event->title ?? 'Onbekend Evenement' }}
                                </h3>
                                <p class="text-[#98A1A8] text-[13px] font-medium flex items-center gap-1.5">
                                    <flux:icon icon="map-pin" class="size-3.5 text-[#00ED64]" />
                                    {{ $ticket->event->venue->name ?? 'Locatie TBA' }}
                                </p>
                            </div>

                            <!-- Horizontal Ticket tear line -->
                            <div class="relative flex items-center justify-between py-2">
                                <div class="absolute -left-10 w-6 h-6 bg-[#001E2B] rounded-full border-r border-white/5"></div>
                                <div class="w-full border-t border-dashed border-white/10"></div>
                                <div class="absolute -right-12 w-6 h-6 bg-[#001E2B] rounded-full border-l border-white/5"></div>
                            </div>

                            <!-- Bottom info -->
                            <div class="flex justify-between items-center text-xs text-[#98A1A8]">
                                <div class="space-y-1">
                                    <p class="text-[9px] uppercase tracking-wider text-[#5C6C75] font-bold">Datum & Tijd</p>
                                    <p class="font-bold text-white">
                                        {{ $ticket->event->start_date ? $ticket->event->start_date->format('d M Y - H:i') : 'TBA' }}
                                    </p>
                                </div>
                                <div class="space-y-1 text-right">
                                    <p class="text-[9px] uppercase tracking-wider text-[#5C6C75] font-bold">Ticket Type</p>
                                    <p class="font-bold text-[#00ED64] uppercase tracking-wider">
                                        {{ $ticket->ticketType->name ?? 'Standaard' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action bar -->
                        <div class="p-6 bg-[#001E2B]/50 border-t border-white/5 flex items-center justify-between">
                            <span class="font-mono text-xs text-[#5C6C75] font-bold">
                                GTX-{{ strtoupper(substr(md5($ticket->id), 0, 10)) }}
                            </span>
                            <a href="{{ route('tickets.show', $ticket) }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#00ED64] hover:bg-[#00D656] text-[#001E2B] rounded-xl text-xs font-black uppercase tracking-wider transition-all duration-300 hover:scale-[1.03] hover:shadow-lg hover:shadow-[#00ED64]/20 cursor-pointer">
                                <flux:icon icon="qr-code" class="size-4" />
                                <span>Bekijk Ticket</span>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
