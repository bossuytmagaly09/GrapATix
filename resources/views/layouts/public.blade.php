<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TechTickets | One platform. Unlimited Events.' }}</title>
    
    <!-- Scripts & Styles -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/frontend.css', 'resources/js/frontend.js'])
</head>
<body class="bg-[#FFFFFF] text-[#001E2B] selection:bg-[#00ED64]/30">
    <!-- Promo Banner -->
    <div class="bg-[#001E2B] text-white text-center py-2 text-[11px] font-semibold tracking-[1px] uppercase">
        Early Bird tickets voor MongoDB World 2026 nu beschikbaar →
    </div>

    <!-- Nav Component -->
    <x-nav />

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer Component -->
    <x-footer />
</body>
</html>
