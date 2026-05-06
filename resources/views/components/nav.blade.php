<nav class="sticky top-0 bg-white/80 backdrop-blur-md border-b border-[#E8EDEB] z-50 px-8 py-4 flex justify-between items-center">
    <div class="flex items-center gap-8">
        <a href="/" class="font-bold text-2xl tracking-tighter text-[#001E2B]">
            Tech<span class="text-[#00ED64]">Tickets</span>
        </a>
        <div class="hidden md:flex gap-6 text-[14px] font-medium text-[#5C6C75]">
            <a href="#" class="hover:text-[#00ED64] transition-colors">Conferenties</a>
            <a href="#" class="hover:text-[#00ED64] transition-colors">Workshops</a>
            <a href="#" class="hover:text-[#00ED64] transition-colors">Certificeringen</a>
        </div>
    </div>
    <div class="flex items-center gap-4">
        @auth
            <a href="{{ route('dashboard') }}" class="text-[14px] font-semibold hover:text-[#00ED64] transition-colors">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="text-[14px] font-semibold hover:text-[#00ED64] transition-colors">Inloggen</a>
            <a href="{{ route('register') }}" class="bg-[#00ED64] text-[#001E2B] px-6 py-2 rounded-full font-bold text-[14px] shadow-sm hover:opacity-90 transition-opacity">Probeer Gratis</a>
        @endauth
    </div>
</nav>
