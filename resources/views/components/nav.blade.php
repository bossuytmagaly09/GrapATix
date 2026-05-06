<nav x-data="{ open: false }" class="sticky top-0 bg-[#001E2B]/80 backdrop-blur-xl border-b border-white/5 z-50">
    <div class="px-6 md:px-12 py-5 flex justify-between items-center">
        <div class="flex items-center gap-8">
            <a href="/" class="font-black text-3xl tracking-tighter text-white">
                GrapA<span class="text-[#00ED64]">Tix</span>
            </a>
            <div class="hidden md:flex gap-6 text-[14px] font-medium text-[#98A1A8]">
                @foreach(\App\Models\Category::take(4)->get() as $navCategory)
                    <a href="{{ route('categories.show', $navCategory->slug) }}" class="hover:text-[#00ED64] transition-colors uppercase font-bold tracking-wider">
                        {{ $navCategory->name }}
                    </a>
                @endforeach
            </div>
        </div>
        
        <div class="flex items-center gap-4">
            <div class="hidden md:flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-[14px] font-semibold hover:text-[#00ED64] transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-[14px] font-semibold hover:text-[#00ED64] transition-colors">Inloggen</a>
                @endauth
            </div>

            <!-- Mobile Menu Toggle -->
            <button @click="open = !open" class="md:hidden p-2 text-[#001E2B] focus:outline-none">
                <flux:icon x-show="!open" icon="bars-3" class="size-7" />
                <flux:icon x-show="open" icon="x-mark" class="size-7" />
            </button>
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="md:hidden bg-[#001E2B]/95 backdrop-blur-2xl border-b border-white/10 absolute w-full left-0 p-8 space-y-8 shadow-2xl z-50"
         @click.away="open = false">
        <div class="flex flex-col gap-6">
            @foreach(\App\Models\Category::take(6)->get() as $navCategory)
                <a href="{{ route('categories.show', $navCategory->slug) }}" class="text-2xl font-black text-white hover:text-[#00ED64] uppercase tracking-tighter transition-colors">
                    {{ $navCategory->name }}
                </a>
            @endforeach
        </div>
        <div class="pt-8 border-t border-white/10 flex flex-col gap-4">
            @auth
                <a href="{{ route('dashboard') }}" class="w-full bg-white text-[#001E2B] text-center py-4 rounded-2xl font-black uppercase tracking-wider">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="w-full bg-[#00ED64] text-[#001E2B] text-center py-4 rounded-2xl font-black uppercase tracking-wider">Inloggen</a>
            @endauth
        </div>
    </div>
</nav>
