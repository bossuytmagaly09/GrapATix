# GrapATix - Ticketing & Event Management Platform

GrapATix is een modern en robuust SaaS platform voor ticketverkoop en evenementenbeheer. Organisatoren kunnen hun evenementen beheren, categorieën toewijzen en veilig tickets verkopen via het Stripe betalingsplatform.

## Project Oplevering & Kwaliteit (Jury Review)

Dit project is gebouwd met strenge focus op test-driven development (TDD), veiligheid en schone code.

### 1. Test Coverage
- **100% Groene Test Suite:** (99/99 Tests Passed)
- Alle kritieke processen (CRUD operaties, Tenant scopes, betaal-simulaties) zijn volledig geautomatiseerd getest via Pest.

### 2. Core Functionaliteiten
- **Tenant Isolatie (Global Scopes):** Data is strikt gescheiden per organisatie. Een organisator kan onder geen beding tickets, evenementen of categorieën van een concurrent bekijken of manipuleren.
- **Veilige Transacties (Stripe Webhooks):** Het betaalproces maakt gebruik van asynchrone webhooks en achtergrondtaken (Jobs). Dit garandeert dat tickets en QR-codes enkel na een geverifieerde betaling gegenereerd worden zonder de server te overbelasten.
- **Data Integriteit (SoftDeletes):** Stamgegevens zoals Categorieën en Evenementen gebruiken `SoftDeletes`. Verwijderde items worden enkel in de interface verborgen (`deleted_at`), waardoor historische transacties en gekoppelde verkochte tickets veilig bewaard blijven voor de boekhouding.

### 3. Codebase Hygiëne
De volledige codebase is vrij van dode code (`dd()`, `dump()`) en ongebruikte test-routes. Alle API en web routes zijn gestroomlijnd en beveiligd met robuuste middlewares (`auth`, `verified`, `can:access-master-dashboard`).

---

## Setup Instructies (Lokale Ontwikkeling)

Zorg dat je WAMP/XAMPP of Laravel Valet hebt draaien.

```bash
# 1. Installeer afhankelijkheden
composer install
npm install

# 2. Configureer je omgeving
cp .env.example .env
php artisan key:generate

# 3. Genereer database en data
php artisan migrate --seed

# 4. Start de applicatie (3 terminals vereist!)
php artisan serve
npm run dev
php artisan queue:work
```

## Stripe Configuratie

Om lokale betalingen te testen, moet je de Stripe CLI starten in een aparte terminal:
```bash
stripe listen --forward-to localhost/api/stripe/webhook
```
Zorg ervoor dat je de Webhook Secret uit de CLI output in je `.env` plakt als `STRIPE_WEBHOOK_SECRET`.
