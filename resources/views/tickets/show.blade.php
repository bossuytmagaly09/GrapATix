<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jouw Ticket - {{ $ticket->event->title ?? 'GrapATix' }}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/frontend.css', 'resources/js/frontend.js'])
</head>
<body class="bg-[#001E2B] text-white selection:bg-[#00ED64]/30">

<div class="bg-[#001E2B] min-h-screen text-white font-sans selection:bg-[#00ED64]/30 py-24 px-6 md:px-12 flex items-center justify-center">
    <div class="max-w-xl w-full bg-[#081621] border border-white/5 rounded-[32px] p-8 md:p-12 shadow-2xl relative overflow-hidden">

        <!-- Glowing Ambient light -->
        <div class="absolute -top-24 -left-24 w-48 h-48 bg-[#00ED64]/10 rounded-full blur-[80px]"></div>
        <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-[#00684A]/20 rounded-full blur-[80px]"></div>

        <div class="space-y-8 relative z-10">

            <!-- Header Icon & Title -->
            <div class="text-center space-y-4">
                <div class="size-20 bg-[#00ED64]/10 border border-[#00ED64]/20 text-[#00ED64] rounded-full flex items-center justify-center mx-auto">
                    <flux:icon icon="ticket" class="size-10" />
                </div>
                <h1 class="text-[32px] md:text-[36px] font-black tracking-tight text-[#00ED64] uppercase">{{ $ticket->event->title ?? 'Event Ticket' }}</h1>
                <p class="text-[#98A1A8] text-[15px]">{{ $ticket->ticketType->name ?? 'Standaard Toegang' }}</p>
            </div>

            <!-- Event Details Card -->
            <div class="bg-[#001E2B] rounded-2xl border border-white/5 p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4 text-[13px] text-[#98A1A8]">
                    <div class="flex items-center gap-2">
                        <flux:icon icon="calendar" class="size-4 text-[#00ED64]" />
                        <span>{{ $ticket->event && $ticket->event->start_date ? $ticket->event->start_date->format('d M Y') . ' @ ' . $ticket->event->start_date->format('H:i') : 'TBA' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <flux:icon icon="map-pin" class="size-4 text-[#00ED64]" />
                        <span>{{ $ticket->event && $ticket->event->venue ? $ticket->event->venue->name : 'Locatie' }}</span>
                    </div>
                </div>
            </div>

            <!-- Ticket Info -->
            <div class="bg-[#001E2B]/50 border border-white/5 rounded-xl p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-lg bg-[#00ED64]/10 text-[#00ED64] flex items-center justify-center font-bold">
                        <flux:icon icon="tag" class="size-5" />
                    </div>
                    <div>
                        <p class="text-[11px] text-[#5C6C75] uppercase tracking-wider font-bold">Ticket ID</p>
                        <p class="text-[14px] font-bold text-white font-mono">GTX-{{ strtoupper(substr(md5($ticket->id), 0, 10)) }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-[#00ED64] text-[12px] font-bold">
                    <flux:icon icon="check-circle" class="size-4" />
                    <span>Geldig</span>
                </div>
            </div>

            <!-- QR Code -->
            <div class="flex flex-col items-center space-y-4">
                <div class="bg-white rounded-2xl p-6">
                    @if($ticket->qr_image_path)
                        <img src="{{ asset('storage/' . $ticket->qr_image_path) }}" alt="Ticket QR Code" class="w-56 h-56">
                    @else
                        <div class="w-56 h-56 flex items-center justify-center bg-gray-100 rounded-lg">
                            <span class="text-xs text-gray-400">Geen QR Beschikbaar</span>
                        </div>
                    @endif
                </div>
                <p class="text-[12px] text-[#5C6C75]">Toon deze QR code aan de inkom</p>
            </div>

            <!-- Action -->
            <div class="pt-4">
                <button onclick="window.close()" class="w-full bg-white/5 hover:bg-white/10 text-white py-3.5 rounded-xl font-bold text-[16px] border border-white/10 hover:border-white/20 transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <flux:icon icon="x-mark" class="size-4" />
                    <span>Sluit Ticket</span>
                </button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
