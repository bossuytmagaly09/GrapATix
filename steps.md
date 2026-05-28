# Project Roadmap: GrapATix - Van Single naar Multi-tenant CMS

Dit document beschrijft de chronologische opbouw van het project. We beginnen met een **Single-tenant focus** (één organisatie) om de kernfunctionaliteit solide te bouwen, en refactoren daarna naar een **Multi-tenant SaaS** structuur.

---

## 🏗️ Fase 1: Basis & Single-tenant CMS
Focus op de kern: Artikelen en Categorieën beheren zonder de complexiteit van tenant-isolatie.

- [x] **1.1 Core Database Modellen**
    - [x] Creëer `Category` model en migratie.
    - [x] Creëer `Article` (of `Event`) model met titel, inhoud, status en afbeelding.
    - [x] **Test:** Valideer met Pest dat je categorieën en artikelen kunt aanmaken en koppelen.
- [x] **1.2 Backend Dashboard (Livewire/Flux)**
    - [x] Bouw CRUD voor Categorieën in het bestaande dashboard.
    - [x] Bouw CRUD voor Artikelen (inclusief image upload en status management).
    - [x] **Test:** Test de volledige CRUD flow in het dashboard met Pest.
- [x] **1.3 Rich Text & SEO (Basis)**
    - [x] Integreer de Rich Text editor.
    - [x] Voeg basis SEO velden toe aan het Article model.
    - [x] **Test:** Controleer of de data correct wordt opgeslagen en getoond.

---

## 🎨 Fase 2: Frontend Integratie
Het omzetten van de `getatix design` naar dynamische pagina's voor onze eerste gebruiker.

- [x] **2.1 Layout & Assets**
    - [x] Integreer CSS/JS uit de design folder via Vite.
    - [x] Maak de `AppLayout` en herbruikbare componenten (Nav, Footer).
- [ ] **2.2 Dynamische Pagina's**
    - [x] Maak de `Home` pagina dynamisch met de laatste artikelen.
    - [x] Bouw de `Category` overzichtspagina met filters.
    - [x] Bouw de `Detail` pagina voor volledige artikelweergave.
    - [ ] **Test:** Verifieer met Pest dat alle frontend pagina's de data uit de database correct tonen.
- [x] **2.3 Mobile-First Optimalisatie**
    - [x] Maak de `Home` en `Detail` pagina's "App-like" op mobiel.
    - [x] Implementeer een sticky mobiele navigatie / CTA.
    - [x] Optimaliseer de Auth-slider voor mobiele schermen.

---

## 🔄 Fase 3: De Switch naar Multi-tenancy
Nu de basis werkt, introduceren we de "SaaS" laag volgens de `rules.md`.

- [x] **3.1 Organization Architectuur**
    - [x] Creëer het `Organization` model.
    - [x] Voeg `organization_id` toe aan de `User`, `Category` en `Event` tabellen via migraties.
    - [ ] **Test:** Valideer dat de database structuur nu klaar is voor meerdere tenants.
- [x] **3.2 Tenant Scoping & Middleware**
    - [x] Implementeer de `TenantScope` (Global Scope) op alle content modellen.
    - [x] Maak de `EnsureTenantContext` middleware voor URL-gebaseerde detectie (bv. via slugs).
    - [x] **Test:** **CRUCIAL:** Schrijf Pest tests die bewijzen dat Organisatie A de artikelen van Organisatie B NOOIT kan zien.
- [/] **3.3 Dashboard Refactoring**
    - [/] Update de dashboard routes naar `/dashboard` (tenant-aware).
    - [/] Voeg de `/dashboard/master` routes toe voor platform-beheer.

---

## 🛒 Fase 4: Ticketing & Stripe Integratie
Het toevoegen van commerciële features aan de multi-tenant structuur.

- [x] **4.1 Order & Ticket Flow**
    - [x] Implementeer `Order` en `Ticket` modellen (tenant-scoped).
    - [x] Bouw de Stripe Checkout integratie (Queue-based Webhooks).
    - [x] **Test:** Mock een betaling.
    - [x] Ontwerp & implementeer een high-end "Success" scherm met gegenereerde tickets.
- [x] **4.2 Real-time Portier Scanner**
    - [x] Bouw signed URL ticket validatie backend (`/tickets/scan/{token}`).
    - [x] Bouw mobile-first dashboard scanner page met `html5-qrcode`.
    - [x] Implementeer Web Audio beeps (hoge beep op succes, lage buzz op waarschuwing/fout).
    - [x] Bouw full-screen overlay feedback en realtime statistieken.
- [x] **4.3 Veilige QR Code Generatie**
    - [x] Genereer Signed URL / unieke hash per ticket.
    - [x] Genereer de daadwerkelijke fysieke QR-code als afbeelding/SVG.
    - [x] Koppel de QR code url en afbeelding aan het Ticket record.

---

## 🚀 Fase 5: Optimalisatie & Finale Check
- [x] **5.1 Queues & Mails**
    - [x] Bouw `TicketPurchaseConfirmation` Mailable met event info en QR bijlagen.
    - [x] Bouw `SendTicketEmailJob` (queue-based, 3 retries).
    - [x] Koppel aan `ProcessStripePaymentJob` — mail wordt automatisch verstuurd na ticketcreatie.
    - [x] **Test:** Valideer via Mailtrap sandbox dat mails correct aankomen.
- [ ] **5.2 Volledige Test Suite**
    - [ ] Draai alle tests (`php artisan test`).
    - [ ] Handmatige security audit op tenant-isolatie.
