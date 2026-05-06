<nav class="sticky top-0 bg-white/80 backdrop-blur-md border-b border-[#E8EDEB] z-50 px-12 py-4 flex justify-between items-center">
    <div class="flex items-center gap-8">
        <a href="/" class="font-bold text-2xl tracking-tighter text-[#001E2B]">
            GrapA<span class="text-[#00ED64]">Tix</span>
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
        @endauth
    </div>
</nav>
