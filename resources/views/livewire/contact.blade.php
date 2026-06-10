<div class="bg-[#001E2B] text-white pt-16 pb-24 px-6 md:px-12 relative overflow-hidden flex-grow flex flex-col justify-center">
    <!-- Glowing Ambient lights -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-[#00ED64]/5 rounded-full blur-[150px] pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-[#00684A]/10 rounded-full blur-[150px] pointer-events-none"></div>

    <div class="max-w-2xl w-full mx-auto space-y-12 relative z-10">
        <!-- Header -->
        <div class="text-center space-y-4">
            <h1 class="text-4xl md:text-5xl font-black tracking-tight text-white uppercase">
                Neem <span class="text-[#00ED64]">Contact</span> op
            </h1>
            <p class="text-[#98A1A8] text-sm md:text-base max-w-xl mx-auto">
                Heb je een vraag over een evenement, ticketverkoop of hulp nodig? Vul het formulier in en we reageren zo snel mogelijk.
            </p>
        </div>

        @if($success)
            <!-- Success Message -->
            <div class="bg-[#081621] border border-[#00ED64]/20 rounded-[32px] p-12 text-center space-y-6 shadow-2xl relative overflow-hidden transition-all duration-500">
                <div class="size-20 bg-[#00ED64]/10 border border-[#00ED64]/20 text-[#00ED64] rounded-full flex items-center justify-center mx-auto shadow-[0_0_15px_rgba(0,237,100,0.15)]">
                    <flux:icon icon="check" class="size-10 text-[#00ED64]" />
                </div>
                <div class="space-y-2">
                    <h3 class="text-2xl font-bold text-white">Bericht Verzonden!</h3>
                    <p class="text-[#98A1A8] text-sm max-w-sm mx-auto">
                        Bedankt voor je bericht. We hebben het ontvangen en nemen zo snel mogelijk contact met je op.
                    </p>
                </div>
                <button wire:click="$set('success', false)" class="inline-flex px-6 py-3 bg-[#00ED64] text-[#001E2B] rounded-xl text-xs font-black uppercase tracking-wider transition-all hover:scale-105 hover:shadow-lg hover:shadow-[#00ED64]/20 cursor-pointer">
                    Nieuw bericht sturen
                </button>
            </div>
        @else
            <!-- Contact Form Card -->
            <form wire:submit="submit" class="bg-[#081621] border border-white/5 rounded-[32px] p-8 md:p-12 shadow-2xl space-y-6 relative">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-xs font-bold text-[#98A1A8] uppercase tracking-wider">Naam</label>
                        <input type="text" id="name" wire:model="name" class="w-full bg-[#001E2B] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:border-[#00ED64]/50 focus:ring-2 focus:ring-[#00ED64]/20 focus:outline-none transition-all text-sm @error('name') border-red-500/50 @enderror" placeholder="Jouw naam">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-xs font-bold text-[#98A1A8] uppercase tracking-wider">E-mailadres</label>
                        <input type="email" id="email" wire:model="email" class="w-full bg-[#001E2B] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:border-[#00ED64]/50 focus:ring-2 focus:ring-[#00ED64]/20 focus:outline-none transition-all text-sm @error('email') border-red-500/50 @enderror" placeholder="jouw@email.nl">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Subject -->
                <div class="space-y-2">
                    <label for="subject" class="block text-xs font-bold text-[#98A1A8] uppercase tracking-wider">Onderwerp</label>
                    <input type="text" id="subject" wire:model="subject" class="w-full bg-[#001E2B] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:border-[#00ED64]/50 focus:ring-2 focus:ring-[#00ED64]/20 focus:outline-none transition-all text-sm @error('subject') border-red-500/50 @enderror" placeholder="Waar gaat je bericht over?">
                    @error('subject')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message -->
                <div class="space-y-2">
                    <label for="message" class="block text-xs font-bold text-[#98A1A8] uppercase tracking-wider">Bericht</label>
                    <textarea id="message" wire:model="message" rows="5" class="w-full bg-[#001E2B] border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:border-[#00ED64]/50 focus:ring-2 focus:ring-[#00ED64]/20 focus:outline-none transition-all text-sm @error('message') border-red-500/50 @enderror" placeholder="Schrijf hier je bericht..."></textarea>
                    @error('message')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" wire:loading.attr="disabled" class="w-full bg-[#00ED64] hover:bg-[#00D656] text-[#001E2B] py-4 rounded-xl font-black uppercase text-xs tracking-wider transition-all duration-300 hover:scale-[1.01] hover:shadow-lg hover:shadow-[#00ED64]/20 flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50">
                    <span wire:loading.remove wire:target="submit">Verstuur bericht</span>
                    <span wire:loading wire:target="submit" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-[#001E2B]" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Verzenden...
                    </span>
                    <flux:icon icon="paper-airplane" class="size-4" />
                </button>
            </form>
        @endif
    </div>
</div>
