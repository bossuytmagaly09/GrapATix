<nav x-data="{ open: false }" class="sticky top-0 bg-[#001E2B]/90 backdrop-blur-xl border-b border-white/5 z-50">
    <div class="px-6 md:px-12 py-5 flex justify-between items-center">
        <div class="flex items-center gap-8">
            <a href="/" class="font-black text-3xl tracking-tighter text-white">
                GrapA<span class="text-[#00ED64]">Tix</span>
            </a>
            <div class="hidden md:flex gap-6 text-[14px] font-medium text-[#98A1A8]">
                @foreach(\App\Models\Category::take(5)->get() as $navCategory)
                    <a href="{{ route('categories.show', $navCategory->slug) }}" class="hover:text-[#00ED64] transition-colors uppercase font-bold tracking-wider text-[12px]">
                        {{ $navCategory->name }}
                    </a>
                @endforeach
            </div>
        </div>
        
        <div class="flex items-center gap-6">
            <!-- Navbar Search Bar (Ticketmaster Style) -->
            <form action="{{ route('home') }}" method="GET" class="hidden md:block relative w-60" onSubmit="return window.location.pathname !== '/';">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-white/40">
                    <flux:icon icon="magnifying-glass" class="size-4" />
                </span>
                <input type="text" name="search" value="{{ request('search') }}" x-on:input="window.location.pathname === '/' ? Livewire.dispatch('search-updated', { query: $event.target.value }) : null" placeholder="Zoek evenementen..." class="w-full pl-9 pr-3 py-2 bg-white/5 border border-white/10 hover:border-white/20 focus:border-[#00ED64] focus:ring-1 focus:ring-[#00ED64] rounded-xl text-[12px] text-white placeholder-white/40 transition-all outline-none">
            </form>

            <div class="hidden md:flex items-center gap-4">
                @auth
                    <!-- User Dropdown (Mannetje Icoon) -->
                    <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                        <button @click="open = !open" type="button" class="flex items-center justify-center w-8 h-8 rounded-lg bg-white/5 border border-white/10 text-white hover:border-[#00ED64]/30 hover:text-[#00ED64] transition-all hover:scale-105" title="{{ auth()->user()->name }}">
                            <flux:icon icon="user" class="size-4" />
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 bg-[#081621] border border-white/10 rounded-xl shadow-2xl z-50 text-white py-1.5 overflow-hidden"
                             style="display: none;">
                             
                            <div class="px-5 py-3 border-b border-white/5 bg-[#001E2B]/50">
                                <div class="font-bold text-white text-sm truncate">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-white/50 truncate mt-0.5">{{ auth()->user()->email }}</div>
                            </div>
                            
                            @if(auth()->user()->organization_id || auth()->user()->can('access-master-dashboard'))
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-white/80 hover:text-white hover:bg-white/5 transition-colors">
                                <flux:icon icon="chart-bar" class="size-4 text-[#00ED64]" />
                                <span>Dashboard</span>
                            </a>
                            @endif
                            
                            <a href="{{ route('my-tickets') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-white/80 hover:text-white hover:bg-white/5 transition-colors">
                                <flux:icon icon="ticket" class="size-4 text-[#00ED64]" />
                                <span>Mijn Tickets</span>
                            </a>
                            
                            <div class="border-t border-white/5 my-1.5"></div>
                            
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-3 px-5 py-3 text-sm text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 transition-colors text-left cursor-pointer">
                                    <flux:icon icon="arrow-right-start-on-rectangle" class="size-4" />
                                    <span>Uitloggen</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 bg-[#00ED64] text-[#001E2B] rounded-xl text-xs font-black uppercase tracking-wider transition-all hover:scale-105 hover:shadow-lg hover:shadow-[#00ED64]/20">
                        Inloggen
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Toggle -->
            <button @click="open = !open" class="md:hidden p-2 text-white hover:text-[#00ED64] focus:outline-none transition-colors">
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
         class="md:hidden bg-[#001E2B]/95 backdrop-blur-2xl border-b border-white/10 absolute w-full left-0 p-8 space-y-6 shadow-2xl z-50"
         @click.away="open = false">
        
        <!-- Mobile Search -->
        <form action="{{ route('home') }}" method="GET" class="relative w-full" onSubmit="return window.location.pathname !== '/';">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-white/40">
                <flux:icon icon="magnifying-glass" class="size-5" />
            </span>
            <input type="text" name="search" value="{{ request('search') }}" x-on:input="window.location.pathname === '/' ? Livewire.dispatch('search-updated', { query: $event.target.value }) : null" placeholder="Zoek evenementen..." class="w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 hover:border-white/20 focus:border-[#00ED64] focus:ring-1 focus:ring-[#00ED64] rounded-2xl text-[14px] text-white placeholder-white/40 transition-all outline-none">
        </form>

        <div class="flex flex-col gap-5 pt-2">
            @foreach(\App\Models\Category::take(5)->get() as $navCategory)
                <a href="{{ route('categories.show', $navCategory->slug) }}" class="text-xl font-bold text-white hover:text-[#00ED64] uppercase tracking-wider transition-colors">
                    {{ $navCategory->name }}
                </a>
            @endforeach
        </div>
        <div class="pt-6 border-t border-white/10 flex flex-col gap-4">
            @auth
                @if(auth()->user()->organization_id || auth()->user()->can('access-master-dashboard'))
                <a href="{{ route('dashboard') }}" class="w-full bg-white text-[#001E2B] text-center py-3.5 rounded-2xl font-black uppercase tracking-wider text-[13px]">Dashboard</a>
                @endif
                
                <a href="{{ route('my-tickets') }}" class="w-full bg-white/5 border border-white/10 text-white text-center py-3.5 rounded-2xl font-black uppercase tracking-wider text-[13px] hover:bg-white/10 transition-all flex items-center justify-center gap-2">
                    <flux:icon icon="ticket" class="size-4 text-[#00ED64]" />
                    <span>Mijn Tickets</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full bg-rose-500/10 border border-rose-500/30 text-rose-400 text-center py-3.5 rounded-2xl font-black uppercase tracking-wider text-[13px] hover:bg-rose-500/20 transition-all flex items-center justify-center gap-2">
                        <flux:icon icon="arrow-right-start-on-rectangle" class="size-4" />
                        {{ __('Log out') }}
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="w-full bg-[#00ED64] text-[#001E2B] text-center py-3.5 rounded-2xl font-black uppercase tracking-wider text-[13px]">Inloggen</a>
            @endauth
        </div>
    </div>
</nav>
