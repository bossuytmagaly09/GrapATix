<x-layouts.public>
    <div class="bg-[#001E2B] text-white pt-16 pb-24 px-6 md:px-12 relative overflow-hidden flex-grow">
        <!-- Glowing Ambient lights -->
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-[#00ED64]/5 rounded-full blur-[150px] pointer-events-none"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-[#00684A]/10 rounded-full blur-[150px] pointer-events-none"></div>

        <div class="max-w-4xl mx-auto space-y-16 relative z-10">
            <!-- Header -->
            <div class="text-center space-y-4">
                <span class="bg-[#00ED64]/10 border border-[#00ED64]/20 text-[#00ED64] px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-wider inline-block">
                    Over GrapATix
                </span>
                <h1 class="text-4xl md:text-6xl font-black tracking-tight text-white uppercase leading-[1.1]">
                    The Next-Gen <br class="hidden md:inline"><span class="text-[#00ED64]">Ticketing</span> Platform
                </h1>
                <p class="text-[#98A1A8] text-base md:text-lg max-w-2xl mx-auto leading-relaxed">
                    GrapATix is ontworpen om organisatoren en bezoekers de meest soepele, veilige en razendsnelle ticketing-ervaring te bieden voor tech-evenementen wereldwijd.
                </p>
            </div>

            <!-- Stats / Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-[#081621] border border-white/5 rounded-[24px] p-8 space-y-4 shadow-xl hover:border-[#00ED64]/20 transition-all duration-300">
                    <div class="size-12 rounded-xl bg-[#00ED64]/10 border border-[#00ED64]/20 flex items-center justify-center text-[#00ED64]">
                        <flux:icon icon="bolt" class="size-6" />
                    </div>
                    <h3 class="text-xl font-bold">Instant Ticketing</h3>
                    <p class="text-[#98A1A8] text-xs leading-relaxed">
                        Geen wachtrijen of vertragingen. Zodra de betaling via Stripe is voltooid, worden je QR-tickets direct gegenereerd en per mail bezorgd.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-[#081621] border border-white/5 rounded-[24px] p-8 space-y-4 shadow-xl hover:border-[#00ED64]/20 transition-all duration-300">
                    <div class="size-12 rounded-xl bg-[#00ED64]/10 border border-[#00ED64]/20 flex items-center justify-center text-[#00ED64]">
                        <flux:icon icon="arrow-trending-up" class="size-6" />
                    </div>
                    <h3 class="text-xl font-bold">Live Statistieken</h3>
                    <p class="text-[#98A1A8] text-xs leading-relaxed">
                        Als organisator beschik je over een real-time dashboard met live scanstatistieken, omzetrapportages en ticket-capaciteit metrics.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="bg-[#081621] border border-white/5 rounded-[24px] p-8 space-y-4 shadow-xl hover:border-[#00ED64]/20 transition-all duration-300">
                    <div class="size-12 rounded-xl bg-[#00ED64]/10 border border-[#00ED64]/20 flex items-center justify-center text-[#00ED64]">
                        <flux:icon icon="shield-check" class="size-6" />
                    </div>
                    <h3 class="text-xl font-bold">Fraudebestendig</h3>
                    <p class="text-[#98A1A8] text-xs leading-relaxed">
                        Beveiligde, cryptografisch getekende QR-tokens. Onze realtime scan-applicatie detecteert direct dubbele of ongeldige tickets bij de deur.
                    </p>
                </div>
            </div>

            <!-- Content Section -->
            <div class="bg-[#081621] border border-white/5 rounded-[32px] p-8 md:p-12 shadow-2xl grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h2 class="text-3xl font-black uppercase tracking-tight">Onze <span class="text-[#00ED64]">Missie</span></h2>
                    <p class="text-[#98A1A8] text-sm leading-relaxed">
                        Bij GrapATix geloven we dat technologie mensen moet verbinden zonder barrières. We bouwen aan een robuust SaaS-platform dat organisatoren volledige autonomie geeft over hun ticketing, en bezoekers een veilige, stressvrije aankoop garandeert.
                    </p>
                    <p class="text-[#98A1A8] text-sm leading-relaxed">
                        Of het nu gaat om een kleinschalige AI workshop, een grootschalige sportwedstrijd of een meerdaags muziekfestival, GrapATix schaalt moeiteloos mee met de behoeften van jouw organisatie.
                    </p>
                </div>
                <div class="relative rounded-2xl overflow-hidden aspect-[4/3] border border-white/10 shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=800" alt="Tech Conference" class="w-full h-full object-cover opacity-80">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#081621] via-transparent to-transparent"></div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
