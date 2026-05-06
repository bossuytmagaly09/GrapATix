<x-layouts.public>
    <x-slot:title>
        TechTickets | Welkom
    </x-slot:title>

    <!-- Hero Section Preview -->
    <header class="bg-[#001E2B] text-white py-24 px-8 overflow-hidden relative">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-12 items-center">
            <div class="hero-content">
                <h1 class="text-[72px] font-medium leading-[1.1] tracking-[-1.5px] mb-6">
                    Een platform. <br><span class="text-[#00ED64]">Onbeperkte events.</span>
                </h1>
                <p class="text-[18px] text-[#98A1A8] mb-8 max-w-md">
                    Ontdek de grootste tech-conferenties wereldwijd. Beheer je tickets, sessies en networking in één interface.
                </p>
                <div class="flex gap-4">
                    <button class="bg-[#00ED64] text-[#001E2B] px-8 py-3 rounded-full font-bold text-[14px]">Ontdek Events</button>
                    <button class="border border-[#3D4F58] px-8 py-3 rounded-full font-bold text-[14px] text-white">Bekijk Demo</button>
                </div>
            </div>
            
            <!-- Code Mockup Card -->
            <div class="code-mockup bg-[#0C1C27] p-8 rounded-[12px] border border-[#3D4F58] shadow-2xl relative">
                <div class="flex gap-2 mb-4">
                    <div class="w-3 h-3 rounded-full bg-[#FF5F56]"></div>
                    <div class="w-3 h-3 rounded-full bg-[#FFBD2E]"></div>
                    <div class="w-3 h-3 rounded-full bg-[#27C93F]"></div>
                </div>
                <pre class="text-[#00ED64] font-mono text-sm leading-relaxed"><code>{
  "event": "MongoDB World 2026",
  "status": "In_Progress",
  "tickets_left": 142,
  "location": "New York, NY",
  "tags": ["Database", "AI", "Cloud"]
}</code></pre>
            </div>
        </div>
    </header>

    <!-- Showcase Section -->
    <section class="py-24 px-8 max-w-7xl mx-auto text-center">
        <h2 class="text-[36px] font-medium mb-6 tracking-tight text-[#001E2B]">De layout is klaar!</h2>
        <p class="text-[#5C6C75] text-[18px] max-w-2xl mx-auto mb-12">
            Je ziet nu de nieuwe Navigatie en Footer. De animaties (GSAP) zijn ook geactiveerd. De volgende stap is om hier de echte events uit de database te tonen.
        </p>
        <div class="grid md:grid-cols-3 gap-8 text-left">
            <div class="event-card bg-white border border-[#E8EDEB] rounded-[12px] p-6 shadow-sm">
                <div class="bg-[#00ED64]/10 h-32 rounded-lg mb-4 flex items-center justify-center">
                    <flux:icon icon="check-circle" class="size-8 text-[#00ED64]" />
                </div>
                <h3 class="font-bold mb-2">Navigatie gelukt</h3>
                <p class="text-[#5C6C75] text-sm">De menu's en buttons werken zoals in het design.</p>
            </div>
            <div class="event-card bg-white border border-[#E8EDEB] rounded-[12px] p-6 shadow-sm">
                <div class="bg-[#00ED64]/10 h-32 rounded-lg mb-4 flex items-center justify-center">
                    <flux:icon icon="check-circle" class="size-8 text-[#00ED64]" />
                </div>
                <h3 class="font-bold mb-2">Footer staat klaar</h3>
                <p class="text-[#5C6C75] text-sm">Alle links en stijlen zijn overgenomen.</p>
            </div>
            <div class="event-card bg-white border border-[#E8EDEB] rounded-[12px] p-6 shadow-sm">
                <div class="bg-[#00ED64]/10 h-32 rounded-lg mb-4 flex items-center justify-center">
                    <flux:icon icon="check-circle" class="size-8 text-[#00ED64]" />
                </div>
                <h3 class="font-bold mb-2">Vite Assets</h3>
                <p class="text-[#5C6C75] text-sm">CSS en JS worden correct gebundeld en ingeladen.</p>
            </div>
        </div>
    </section>
</x-layouts.public>
