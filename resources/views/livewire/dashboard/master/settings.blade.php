<div class="space-y-8 bg-[#001E2B] p-6 rounded-3xl border border-white/5 min-h-[85vh] text-white">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-white/5 pb-6">
        <div>
            <h1 class="text-3xl font-black uppercase tracking-tight text-[#00ED64]">
                Platform <span class="text-white">Instellingen</span>
            </h1>
            <p class="text-white/60 text-sm mt-1">Globale configuratie voor het volledige GrapATix platform.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard.master') }}" class="px-4 py-2 bg-[#081621] border border-white/10 hover:border-[#00ED64]/50 rounded-xl text-xs font-bold uppercase tracking-wider transition-all text-white hover:scale-105">
                Dashboard
            </a>
        </div>
    </div>

    <!-- Settings Form -->
    <div class="max-w-4xl">
        <form wire:submit.prevent="save" class="space-y-8">
            <!-- Algemeen -->
            <div class="bg-[#081621] border border-white/5 p-6 rounded-2xl">
                <h3 class="text-lg font-bold text-white mb-4 border-b border-white/5 pb-2">Algemeen</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <flux:label class="text-white/80 font-bold mb-1">Platform Naam</flux:label>
                        <flux:input wire:model="platform_name" class="bg-[#001E2B] border-white/10 text-white rounded-xl focus:border-[#00ED64]" />
                    </div>
                    <div>
                        <flux:label class="text-white/80 font-bold mb-1">Support E-mailadres</flux:label>
                        <flux:input wire:model="support_email" type="email" class="bg-[#001E2B] border-white/10 text-white rounded-xl focus:border-[#00ED64]" />
                        <p class="text-white/40 text-[10px] mt-1">Dit adres wordt gebruikt in emails naar kopers en tenants.</p>
                    </div>
                </div>
            </div>

            <!-- Financiën -->
            <div class="bg-[#081621] border border-[#00ED64]/20 p-6 rounded-2xl shadow-lg shadow-[#00ED64]/5">
                <h3 class="text-lg font-bold text-[#00ED64] mb-4 border-b border-white/5 pb-2">Financiën & Prijzen</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <flux:label class="text-white/80 font-bold mb-1">Standaard Platform Fee (%)</flux:label>
                        <div class="flex items-center">
                            <flux:input wire:model="platform_fee_percentage" type="number" step="0.1" class="bg-[#001E2B] border-white/10 text-white rounded-xl focus:border-[#00ED64] w-24 text-right" />
                            <span class="ml-2 text-white/50 font-bold">%</span>
                        </div>
                        <p class="text-white/40 text-[10px] mt-1">Het percentage van de brutoverkoop dat het platform inhoudt per bestelling.</p>
                    </div>
                    
                    <div>
                        <flux:label class="text-white/80 font-bold mb-1">Stripe Modus</flux:label>
                        <flux:select wire:model="stripe_mode" class="bg-[#001E2B] border-white/10 text-white rounded-xl focus:border-[#00ED64]">
                            <flux:select.option value="test">Test Mode (Sandbox)</flux:select.option>
                            <flux:select.option value="live">Live Mode (Production)</flux:select.option>
                        </flux:select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-[#00ED64] text-[#001E2B] rounded-xl text-sm font-bold uppercase tracking-wider transition-all shadow-md shadow-[#00ED64]/20 hover:scale-105 flex items-center gap-2">
                    <flux:icon icon="check" class="size-5" />
                    Instellingen Opslaan
                </button>
            </div>
        </form>
    </div>
</div>
