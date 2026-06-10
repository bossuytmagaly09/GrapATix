<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jouw Ticket - {{ $ticket->event->title ?? 'GrapATix' }}</title>
    
    <!-- Scripts & Styles -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/frontend.css', 'resources/js/frontend.js'])
    @fluxAppearance
</head>
<body class="bg-[#001E2B] text-white selection:bg-[#00ED64]/30 min-h-screen antialiased flex flex-col justify-between">

<div class="min-h-screen text-white font-sans py-16 px-6 md:px-12 flex flex-col items-center justify-center relative overflow-hidden">
    <!-- Glowing Ambient lights -->
    <div class="absolute -top-48 -left-48 w-[400px] h-[400px] bg-[#00ED64]/10 rounded-full blur-[120px]"></div>
    <div class="absolute -bottom-48 -right-48 w-[400px] h-[400px] bg-[#00684A]/20 rounded-full blur-[120px]"></div>

    <!-- Main Container -->
    <div class="max-w-md w-full relative">
        
        <!-- Physical Ticket Card -->
        <div class="bg-[#081621] border border-white/5 rounded-[32px] shadow-2xl relative overflow-hidden flex flex-col justify-between">
            
            <!-- Glow Accent Line at Top -->
            <div class="h-1.5 w-full bg-gradient-to-r from-[#00684A] via-[#00ED64] to-[#00684A]"></div>

            <!-- Top Stub: Ticket Details -->
            <div class="p-8 space-y-6">
                <!-- Header Icon & Category -->
                <div class="flex justify-between items-center">
                    <span class="px-2.5 py-1 bg-[#00ED64]/10 border border-[#00ED64]/20 rounded-lg text-[10px] font-bold text-[#00ED64] uppercase tracking-wider">
                        {{ $ticket->event->category->name ?? 'Evenement' }}
                    </span>
                    <div class="size-8 bg-[#00ED64]/10 border border-[#00ED64]/20 text-[#00ED64] rounded-lg flex items-center justify-center">
                        <flux:icon icon="ticket" class="size-4" />
                    </div>
                </div>

                <!-- Event Title & Ticket Type -->
                <div class="space-y-2">
                    <h1 class="text-2xl md:text-3xl font-black uppercase text-[#00ED64] tracking-tight leading-tight">
                        {{ $ticket->event->title ?? 'Evenement' }}
                    </h1>
                    <p class="text-[#98A1A8] text-xs font-semibold uppercase tracking-wider">
                        {{ $ticket->ticketType->name ?? 'Standaard Toegang' }}
                    </p>
                </div>

                <!-- Location & Time grid -->
                <div class="bg-[#001E2B]/60 rounded-xl border border-white/5 p-4 space-y-3 text-xs text-[#98A1A8]">
                    <div class="flex items-center gap-2">
                        <flux:icon icon="calendar" class="size-4 text-[#00ED64]" />
                        <span class="font-medium text-white">{{ $ticket->event && $ticket->event->start_date ? $ticket->event->start_date->format('d M Y') . ' @ ' . $ticket->event->start_date->format('H:i') : 'TBA' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <flux:icon icon="map-pin" class="size-4 text-[#00ED64]" />
                        <span class="font-medium text-white">{{ $ticket->event && $ticket->event->venue ? $ticket->event->venue->name : 'Locatie TBA' }}</span>
                    </div>
                </div>
            </div>

            <!-- Ticket Tear Line with side circles -->
            <div class="relative flex items-center justify-between py-1 bg-[#081621]">
                <!-- Left cutout -->
                <div class="absolute -left-5 w-10 h-10 bg-[#001E2B] rounded-full border-r border-white/5 z-20"></div>
                <!-- Dashed line -->
                <div class="w-full border-t border-dashed border-white/10 mx-6"></div>
                <!-- Right cutout -->
                <div class="absolute -right-5 w-10 h-10 bg-[#001E2B] rounded-full border-l border-white/5 z-20"></div>
            </div>

            <!-- Bottom Stub: QR Code & Validation -->
            <div class="p-8 space-y-6 bg-[#001E2B]/30">
                <!-- Status & Ticket ID -->
                <div class="flex items-center justify-between">
                    <div class="space-y-0.5">
                        <p class="text-[9px] uppercase tracking-wider text-[#5C6C75] font-bold">Ticket ID</p>
                        <p class="text-[13px] font-bold text-white font-mono">GTX-{{ strtoupper(substr(md5($ticket->id), 0, 10)) }}</p>
                    </div>
                    <div class="flex items-center gap-1.5 text-[#00ED64] text-[11px] font-bold bg-[#00ED64]/10 border border-[#00ED64]/20 px-3 py-1 rounded-full">
                        <span class="size-2 rounded-full bg-[#00ED64] {{ $ticket->status === 'scanned' ? 'bg-white/30' : 'bg-[#00ED64] animate-pulse' }}"></span>
                        <span>{{ $ticket->status === 'scanned' ? 'Reeds gescand' : 'Geldig ticket' }}</span>
                    </div>
                </div>

                <!-- QR Code Wrapper -->
                <div class="flex flex-col items-center space-y-3 bg-[#081621] border border-white/5 rounded-2xl p-6 shadow-xl">
                    <div class="bg-white rounded-xl p-4 shadow-inner">
                        @if($ticket->qr_image_path)
                            <img src="{{ asset('storage/' . $ticket->qr_image_path) }}" alt="Ticket QR Code" class="w-48 h-48 mx-auto">
                        @else
                            <div class="w-48 h-48 flex items-center justify-center bg-gray-100 rounded-lg">
                                <flux:icon icon="qr-code" class="size-16 text-gray-300" />
                            </div>
                        @endif
                    </div>
                    <p class="text-[11px] text-[#5C6C75] font-semibold uppercase tracking-wider">Toon deze QR code aan de inkom</p>
                </div>

                <!-- Action Button -->
                <div class="pt-2">
                    <button onclick="window.close()" class="w-full bg-white/5 hover:bg-white/10 text-white py-3 rounded-xl font-bold text-[14px] border border-white/10 hover:border-white/20 transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <flux:icon icon="x-mark" class="size-4" />
                        <span>Sluit Ticket</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

@fluxScripts
</body>
</html>
