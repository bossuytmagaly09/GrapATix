<div class="space-y-8 bg-[#001E2B] p-6 rounded-3xl border border-white/5 min-h-[85vh] text-white">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-white/5 pb-6">
        <div>
            <h1 class="text-3xl font-black uppercase tracking-tight text-[#00ED64]">
                Organisatie <span class="text-white">Instellingen</span>
            </h1>
            <p class="text-white/60 text-sm mt-1">Beheer functies voor jouw GrapATix ticketshop.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-[#081621] border border-white/10 hover:border-[#00ED64]/50 rounded-xl text-xs font-bold uppercase tracking-wider transition-all text-white hover:scale-105">
                Dashboard
            </a>
        </div>
    </div>

    <!-- Settings Form -->
    <div class="max-w-4xl">
        <form wire:submit.prevent="save" class="space-y-8">
            <!-- Algemeen -->
            <div class="bg-[#081621] border border-white/5 p-6 rounded-2xl shadow-lg">
                <h3 class="text-lg font-bold text-white mb-4 border-b border-white/5 pb-2">Functionaliteiten</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <flux:label class="text-white/80 font-bold mb-1">Maak gebruik van Categorieën</flux:label>
                        <flux:switch wire:model="uses_categories" class="mt-2" />
                        <p class="text-white/40 text-[10px] mt-2">Zet dit aan als je jouw evenementen wilt onderverdelen in verschillende categorieën (zoals Festivals, Concerten, enzovoort). Als dit uitstaat, is het menu voor categorieën verborgen.</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-[#00ED64] text-[#001E2B] rounded-xl text-sm font-bold uppercase tracking-wider transition-all shadow-md shadow-[#00ED64]/20 hover:scale-105 flex items-center gap-2">
                    <flux:icon icon="check" class="size-5" />
                    Opslaan
                </button>
            </div>
        </form>
    </div>
</div>
