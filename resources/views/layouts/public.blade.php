<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TechTickets | One platform. Unlimited Events.' }}</title>
    
    <!-- Scripts & Styles -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/frontend.css', 'resources/js/frontend.js'])
    @fluxAppearance
</head>
<body class="bg-[#001E2B] text-white selection:bg-[#00ED64]/30 min-h-screen flex flex-col">

    <!-- Nav Component -->
    <x-nav />

    <!-- Main Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer Component -->
    <x-footer />
    
    @fluxScripts
</body>
</html>
