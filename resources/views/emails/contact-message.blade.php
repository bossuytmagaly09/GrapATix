@component('mail::message')
# Nieuw contactbericht van GrapATix

Er is een nieuw bericht ontvangen via het contactformulier van GrapATix.

**Naam:** {{ $name }}  
**E-mail:** {{ $email }}  
**Onderwerp:** {{ $subjectText }}  

**Bericht:**  
{{ $messageText }}  

Met vriendelijke groet,<br>
{{ config('app.name') }}
@endcomponent
