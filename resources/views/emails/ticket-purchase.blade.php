@component('mail::message')

# Bedankt voor je aankoop! 🎉

Hallo {{ $recipientName }},

Je betaling is succesvol verwerkt. Hieronder vind je de details van je bestelling.

---

## 📅 {{ $event->title ?? 'Evenement' }}

@if($event && $event->start_date)
**Datum:** {{ $event->start_date->format('d M Y') }} om {{ $event->start_date->format('H:i') }}
@endif

@if($event && $event->venue)
**Locatie:** {{ $event->venue->name }}
@endif

---

## 🎫 Jouw Tickets ({{ $tickets->count() }})

@foreach($tickets as $ticket)
### 🎫 {{ $ticket->ticketType->name ?? 'Standaard' }}
**Ticket Code:** GTX-{{ strtoupper(substr(md5($ticket->id), 0, 10)) }}

<div style="text-align: center; margin: 15px 0;">
    <img src="{{ $message->embed(Illuminate\Support\Facades\Storage::disk('public')->path($ticket->qr_image_path)) }}" alt="QR Code" style="width: 150px; height: 150px; border: 1px solid #e2e8f0; padding: 10px; border-radius: 8px; background-color: #ffffff; display: inline-block;">
</div>
@endforeach

> De QR-codes van je tickets zijn als bijlage meegestuurd met deze e-mail. Toon de juiste QR-code aan de inkom om binnen te geraken.



Tot op het evenement! 🙌

Met vriendelijke groeten,<br>
**Het GrapATix Team**

@endcomponent
