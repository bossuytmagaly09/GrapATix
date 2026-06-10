<x-layouts.public>
    <div class="bg-[#001E2B] text-white pt-16 pb-24 px-6 md:px-12 relative overflow-hidden flex-grow">
        <!-- Glowing Ambient lights -->
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-[#00ED64]/5 rounded-full blur-[150px] pointer-events-none"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-[#00684A]/10 rounded-full blur-[150px] pointer-events-none"></div>

        <div class="max-w-3xl mx-auto space-y-12 relative z-10">
            <!-- Header -->
            <div class="space-y-4">
                <span class="bg-[#00ED64]/10 border border-[#00ED64]/20 text-[#00ED64] px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-wider inline-block">
                    Privacy Policy
                </span>
                <h1 class="text-4xl md:text-5xl font-black tracking-tight text-white uppercase">
                    Privacyverklaring van <span class="text-[#00ED64]">GrapATix</span>
                </h1>
                <p class="text-[#98A1A8] text-xs">
                    Laatst bijgewerkt: {{ date('d F Y') }}
                </p>
            </div>

            <!-- Content Card -->
            <div class="bg-[#081621] border border-white/5 rounded-[32px] p-8 md:p-12 shadow-2xl space-y-8 leading-relaxed text-[#98A1A8] text-sm">
                
                <section class="space-y-4">
                    <h2 class="text-xl font-bold text-white uppercase tracking-wider text-[#00ED64]">1. Algemeen</h2>
                    <p>
                        GrapATix respecteert de privacy van alle gebruikers van haar site en draagt er zorg voor dat de persoonlijke informatie die u ons verschaft vertrouwelijk wordt behandeld. Wij gebruiken uw gegevens om de bestellingen van tickets zo snel en gemakkelijk mogelijk te laten verlopen. Voor het overige zullen wij deze gegevens uitsluitend gebruiken met uw toestemming.
                    </p>
                </section>

                <section class="space-y-4">
                    <h2 class="text-xl font-bold text-white uppercase tracking-wider text-[#00ED64]">2. Verzamelen van Persoonsgegevens</h2>
                    <p>
                        Wanneer u een ticket koopt of zich registreert als organisatie, verzamelen we de volgende gegevens:
                    </p>
                    <ul class="list-disc list-inside space-y-2 pl-4">
                        <li>Naam en e-mailadres (voor ticketlevering en accountbeheer).</li>
                        <li>Organisatienaam en gewenst subdomein (indien u zich registreert als organisator).</li>
                        <li>Betalingsgegevens (verwerkt en beveiligd door onze betalingspartner Stripe).</li>
                        <li>IP-adres en browser User-Agent (voor fraudepreventie en scan-audits).</li>
                    </ul>
                </section>

                <section class="space-y-4">
                    <h2 class="text-xl font-bold text-white uppercase tracking-wider text-[#00ED64]">3. Doeleinden van Gegevensverwerking</h2>
                    <p>
                        GrapATix gebruikt de verzamelde gegevens om haar relaties de volgende diensten te leveren:
                    </p>
                    <ul class="list-disc list-inside space-y-2 pl-4">
                        <li>Als u een bestelling plaatst, hebben we uw naam en e-mailadres nodig om uw bestelling uit te voeren en u uw QR-toegangsticket toe te sturen.</li>
                        <li>Wanneer tickets bij de deur worden gescand, registreren we het scantijdstip en de geldigheid van het ticket om dubbele invoer te voorkomen.</li>
                        <li>Als u ons contactformulier invult, gebruiken we uw gegevens om op uw vragen te kunnen reageren.</li>
                    </ul>
                </section>

                <section class="space-y-4">
                    <h2 class="text-xl font-bold text-white uppercase tracking-wider text-[#00ED64]">4. Beveiliging en Bewaartermijn</h2>
                    <p>
                        Wij nemen de bescherming van uw gegevens serieus en nemen passende maatregelen om misbruik, verlies, onbevoegde toegang, ongewenste openbaarmaking en ongeoorloofde wijziging tegen te gaan. Uw persoonsgegevens worden niet langer bewaard dan strikt nodig is om de doelen te realiseren waarvoor uw gegevens worden verzameld.
                    </p>
                </section>

                <section class="space-y-4">
                    <h2 class="text-xl font-bold text-white uppercase tracking-wider text-[#00ED64]">5. Delen met Derden</h2>
                    <p>
                        GrapATix verkoopt uw persoonlijke gegevens niet aan derden en zal deze uitsluitend aan derden ter beschikking stellen die zijn betrokken bij het uitvoeren van uw bestelling (bijvoorbeeld betalingsprovider Stripe voor het afhandelen van betalingstransacties).
                    </p>
                </section>

                <section class="space-y-4">
                    <h2 class="text-xl font-bold text-white uppercase tracking-wider text-[#00ED64]">6. Uw Rechten</h2>
                    <p>
                        U heeft het recht om uw persoonsgegevens in te zien, te corrigeren of te verwijderen. Daarnaast heeft u het recht om uw eventuele toestemming voor de gegevensverwerking in te trekken of bezwaar te maken tegen de verwerking van uw persoonsgegevens door GrapATix. Neem hiervoor contact met ons op via het contactformulier.
                    </p>
                </section>
                
            </div>
        </div>
    </div>
</x-layouts.public>
