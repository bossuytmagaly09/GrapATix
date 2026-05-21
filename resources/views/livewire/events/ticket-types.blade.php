<div class="space-y-8 bg-[#001E2B] p-6 rounded-3xl border border-white/5 min-h-[85vh] text-white">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-white/5 pb-6 mb-6">
        <div>
            <h1 class="text-3xl font-black uppercase tracking-tight text-[#00ED64]">
                Tickets <span class="text-white">Beheren</span>
            </h1>
            <p class="text-white/60 text-sm mt-1">Stel in welke tickets beschikbaar zijn voor <strong>{{ $event->title }}</strong>.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('events.index') }}" class="px-4 py-2 bg-[#081621] border border-white/10 hover:border-[#00ED64]/50 rounded-xl text-xs font-bold uppercase tracking-wider transition-all text-white hover:scale-105">
                Terug naar Events
            </a>
            @if(!$editingId)
                <button wire:click="$set('editingId', 'new')" class="px-4 py-2 bg-[#00ED64] text-[#001E2B] rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-md shadow-[#00ED64]/20 hover:scale-105 flex items-center gap-2">
                    <flux:icon icon="plus" class="size-4" />
                    Nieuw Type
                </button>
            @endif
        </div>
    </div>
    <!-- Formulier (Tonen als we aanmaken of bewerken) -->
    @if($editingId)
        <div class="bg-[#081621] p-6 rounded-2xl border border-white/5 mb-8">
            <h4 class="text-lg font-bold text-[#00ED64] mb-4">{{ $editingId === 'new' ? 'Nieuw Ticket Type' : 'Ticket Type Bewerken' }}</h4>
            
            <form wire:submit.prevent="save" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <flux:input wire:model="name" label="Naam (bijv. Early Bird, VIP)" required />
                </div>
                
                <div>
                    <flux:input wire:model.number="price_cents" type="number" label="Prijs (in centen, 1500 = €15,00)" required />
                </div>

                <div>
                    <flux:input wire:model.number="available_quantity" type="number" label="Beschikbaar aantal (capaciteit)" required />
                </div>

                <div class="flex items-center mt-6">
                    <flux:switch wire:model="is_published" label="Zichtbaar voor verkoop" />
                </div>

                <div class="md:col-span-2 flex justify-end gap-3 mt-4">
                    <button type="button" wire:click="resetForm" class="px-4 py-2 bg-transparent border border-white/10 text-white hover:border-white/30 rounded-xl text-sm font-bold uppercase tracking-wider transition-colors">
                        Annuleren
                    </button>
                    <button type="submit" class="px-4 py-2 bg-[#00ED64] text-[#001E2B] rounded-xl text-sm font-bold uppercase tracking-wider transition-all shadow-md shadow-[#00ED64]/20 hover:scale-105 flex items-center gap-2">
                        <flux:icon icon="check" class="size-4" />
                        Opslaan
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- Lijst van bestaande ticket types -->
    <div class="space-y-4">
        @forelse($ticketTypes as $type)
            <div class="bg-[#001E2B] p-4 rounded-xl border border-white/5 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 hover:border-[#00ED64]/50 transition-colors">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <h4 class="font-bold text-white text-lg">{{ $type->name }}</h4>
                        @if($type->is_published)
                            <span class="px-2 py-0.5 bg-[#00ED64]/10 text-[#00ED64] rounded text-[10px] font-bold uppercase border border-[#00ED64]/20">Actief</span>
                        @else
                            <span class="px-2 py-0.5 bg-white/10 text-white/50 rounded text-[10px] font-bold uppercase border border-white/10">Verborgen</span>
                        @endif
                    </div>
                    <div class="text-white/50 text-sm flex gap-4">
                        <span>Prijs: <strong class="text-white">€{{ number_format($type->price_cents / 100, 2, ',', '.') }}</strong></span>
                        <span>Capaciteit: <strong class="text-white">{{ $type->available_quantity }}</strong> stuks</span>
                        <span>Verkocht: <strong class="text-[#00ED64]">{{ $type->tickets()->count() }}</strong></span>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    <button wire:click="edit({{ $type->id }})" class="p-2 text-white/50 hover:text-[#00ED64] bg-white/5 hover:bg-[#00ED64]/10 rounded-lg transition-colors" title="Bewerken">
                        <flux:icon icon="pencil" class="size-5" />
                    </button>
                    <button wire:click="delete({{ $type->id }})" onclick="confirm('Weet je zeker dat je dit ticket type wilt verwijderen?') || event.stopImmediatePropagation()" class="p-2 text-white/50 hover:text-rose-500 bg-white/5 hover:bg-rose-500/10 rounded-lg transition-colors" title="Verwijderen">
                        <flux:icon icon="trash" class="size-5" />
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center p-8 border border-dashed border-white/10 rounded-2xl bg-[#001E2B]/50">
                <flux:icon icon="ticket" class="size-12 mx-auto text-white/20 mb-3" />
                <p class="text-white/50 text-sm">Er zijn nog geen ticket soorten aangemaakt voor dit evenement.</p>
            </div>
        @endforelse
    </div>
</div>
