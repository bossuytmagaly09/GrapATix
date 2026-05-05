rules.md
Doel van dit document

Dit document is de vaste bouw- en schrijfrichtlijn voor dit project in VS Code. Alles moet compatibel zijn met:

Laravel 13
Livewire 4
Laravel Livewire starter kit
Flux UI free tier
MySQL of MariaDB
Pest

Dit project is een multi-tenant ticketing platform (SaaS) gebaseerd op getatix design.zip.

Het systeem ondersteunt:

meerdere organisaties (tenants)
eigen dashboards per organisatie
een centrale master backend
ticketverkoop + scanning
betalingen via Stripe
QR-code validatie
mails en notificaties
Projectcontext
Hoofddoel

Bouw een multi-tenant ticketing SaaS met:

publieke event/ticket aankoop flow
user dashboard (tickets beheren)
QR-ticket scanning
organisatie dashboards
master admin dashboard
Stripe integratie
queue-based verwerking
mail notificaties
Multi-tenancy (KRITISCH)
Architectuurkeuze (verplicht)

Gebruik single database multi-tenancy met tenant scoping.

Elke tenant (organisatie) heeft:

eigen data (tickets, events, users)
eigen branding (optioneel later)
eigen Stripe configuratie (indien nodig)
Tenant model
Organization

Velden:

id
name
slug
stripe_account_id (optioneel voor connect)
timestamps
Tenant scoping (verplicht)

Alle modellen moeten scoped worden op:

organization_id
Regels
NOOIT data ophalen zonder tenant scope
Global scope of expliciete filtering verplicht
Policies moeten tenant-aware zijn
Master vs Tenant backend
Master backend

Route:

/dashboard/master/*

Functionaliteiten:

organisaties beheren
platform metrics
globale instellingen
Tenant backend

Route:

/dashboard

Functionaliteiten:

events beheren
tickets beheren
orders bekijken
scans opvolgen
Domeinstructuur

Uitgebreid:

Organizations
Events
Tickets
Orders
Payments
Scans
Users
Admin
Nieuwe kernentiteiten
Event
id
organization_id
name
description
location
start_date
end_date
price
capacity
timestamps
Ticket
id
event_id
user_id
qr_code
status
scanned_at (nullable)
timestamps
Order
id
organization_id
user_id
total_amount
status
stripe_session_id
timestamps
ScanLog
id
ticket_id
scanned_by (user/admin)
scanned_at
device_info (optioneel)
QR-code regels
Verplicht
elk ticket heeft unieke QR-code
QR bevat:
signed token (geen plain ID)
validatie via backend endpoint
Scan flow
QR scan
API call
validatie:
bestaat ticket
juiste tenant
niet reeds gescand
markeer als gescand
log in ScanLog
Verboden
QR zonder signing
validatie client-side
Stripe regels
Verplicht

Gebruik:

Stripe Checkout
webhook verificatie
Flow
user koopt ticket
Order → pending
Stripe session
webhook bevestigt betaling
tickets worden gegenereerd
Multi-tenant
Stripe per organisatie OF platform account
geen hardcoded keys
Verboden
success via query param vertrouwen
Queue systeem (VERPLICHT)

Gebruik queues voor:

ticket generatie
mail verzending
QR-code generatie
Stripe webhook verwerking
Config
queue driver: database of redis
jobs in app/Jobs
Voorbeelden
GenerateTicketsJob
SendTicketEmailJob
ProcessStripeWebhookJob
Mail systeem
Verplicht

Gebruik:

Laravel Mailables
Flow

Na aankoop:

bevestigingsmail
tickets als QR (inline of attachment)
Types
Order confirmation
Ticket delivery
Reminder (optioneel)
Livewire regels (uitbreiding)

Extra:

realtime scanning UI (optioneel met polling)
dashboard metrics via computed properties
Policies (uitbreiding)
tenant isolation verplicht
user mag enkel eigen tickets zien
admin enkel binnen eigen organisatie
Middleware

Nieuwe:

EnsureTenantContext
EnsureUserBelongsToOrganization
Security regels
tenant leakage = CRITICAL BUG
alle queries tenant-aware
signed routes voor QR
Testing (uitgebreid)
Extra tests
multi-tenant isolation test
Stripe webhook test
QR scan test
queue job test
Frontend mapping (getatix)
Extra vertalingen
Event listing
events per organisatie
Ticket aankoop
flow met Stripe
Scan interface
mobile-first UI
Bestanden (uitgebreid)
Models
Organization.php
Event.php
Ticket.php
Order.php
ScanLog.php
Jobs
GenerateTicketsJob.php
SendTicketEmailJob.php
ProcessStripeWebhookJob.php
Services
StripeService.php
QrCodeService.php
TicketService.php
Ontwikkelfases (aangepast)
Fase 1
tenancy structuur
Organization model
scoping
Fase 2
events + tickets
Fase 3
Stripe + orders
Fase 4
QR scanning
Fase 5
queues + mails
Fase 6
dashboards (tenant + master)
Anti-patronen (uitgebreid)

Weiger:

geen tenant scoping
sync mail verzending
Stripe zonder webhook
QR zonder validatie
admin toegang zonder role checks
Definitie van klaar
multi-tenant correct
geen datalekken
Stripe correct
QR scanning veilig
queues actief
mails werken
dashboards gescheiden
Samenvattende hoofdregel

Bouw dit project als een multi-tenant SaaS ticketing platform waarbij:

elke organisatie volledig geïsoleerd werkt
een master backend controle behoudt
betalingen, tickets en scans betrouwbaar verlopen
queues en mails production-ready zijn

Geen shortcuts. Dit is een enterprise-level architectuur.