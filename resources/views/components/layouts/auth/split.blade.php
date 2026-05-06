<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="antialiased bg-[#001E2B] overflow-hidden">
    {{ $slot }}
    @fluxScripts
</body>
</html>
