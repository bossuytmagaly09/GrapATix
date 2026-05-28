<x-layouts.public title="Ticket Scan Resultaat | GrapATix">
    <div class="min-h-[70vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-55/10">
        <div class="max-w-md w-full space-y-8 p-8 rounded-2xl shadow-xl border text-center transition-all duration-300
            @if($status === 'success') bg-emerald-50/90 border-emerald-200 text-emerald-950
            @elseif($status === 'warning') bg-amber-50/90 border-amber-200 text-amber-950
            @else bg-rose-50/90 border-rose-200 text-rose-950
            @endif">
            
            <div class="flex flex-col items-center justify-center">
                @if($status === 'success')
                    <!-- Success Check Icon -->
                    <div class="w-20 h-20 bg-emerald-500 text-white rounded-full flex items-center justify-center shadow-lg shadow-emerald-500/30 mb-6 animate-bounce">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-extrabold tracking-tight">GELDIG TICKET ✅</h1>
                @elseif($status === 'warning')
                    <!-- Warning/Already Scanned Icon -->
                    <div class="w-20 h-20 bg-amber-500 text-white rounded-full flex items-center justify-center shadow-lg shadow-amber-500/30 mb-6 animate-pulse">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-extrabold tracking-tight">AL GEBRUIKT ⚠️</h1>
                @else
                    <!-- Error Cross Icon -->
                    <div class="w-20 h-20 bg-rose-500 text-white rounded-full flex items-center justify-center shadow-lg shadow-rose-500/30 mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-extrabold tracking-tight">ONGELDIG TICKET ❌</h1>
                @endif

                <p class="mt-4 text-base font-medium opacity-90 max-w-sm">
                    {{ $message }}
                </p>
            </div>

            <!-- Details Block -->
            @if(isset($ticket))
                <div class="mt-8 border-t border-slate-200/50 pt-6 text-left space-y-4">
                    <div class="flex justify-between items-center py-1 border-b border-dashed border-slate-200/30">
                        <span class="text-xs font-semibold uppercase tracking-wider opacity-60">Bezoeker</span>
                        <span class="text-sm font-bold">{{ $ticket->user->name ?? 'Gast/Klant' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1 border-b border-dashed border-slate-200/30">
                        <span class="text-xs font-semibold uppercase tracking-wider opacity-60">Evenement</span>
                        <span class="text-sm font-bold">{{ $ticket->event->title ?? 'Evenement' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1 border-b border-dashed border-slate-200/30">
                        <span class="text-xs font-semibold uppercase tracking-wider opacity-60">Ticket Type</span>
                        <span class="text-sm font-bold">{{ $ticket->ticketType->name ?? 'Standaard' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1 border-b border-dashed border-slate-200/30">
                        <span class="text-xs font-semibold uppercase tracking-wider opacity-60">Ticket Code</span>
                        <span class="text-xs font-mono font-bold">GTX-{{ strtoupper(substr(md5($ticket->id), 0, 10)) }}</span>
                    </div>
                </div>
            @endif

            <!-- Button back -->
            <div class="mt-8">
                <a href="/" class="inline-flex items-center justify-center px-6 py-2.5 border border-transparent text-sm font-bold rounded-lg shadow-sm text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-colors">
                    Terug naar Home
                </a>
            </div>
        </div>
    </div>
</x-layouts.public>
