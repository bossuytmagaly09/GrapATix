<footer class="bg-[#001E2B] text-white pt-10 pb-12 px-6 md:px-12 mt-8 relative">
    <!-- Playful ticket/music-themed divider at the top of the footer -->
    <div class="absolute top-0 left-0 w-full flex flex-col items-center justify-center -translate-y-1/2 pointer-events-none">
        <!-- Main Neon Green Glow Line -->
        <div class="w-full h-[1.5px] bg-gradient-to-r from-transparent via-[#00ED64]/40 to-transparent"></div>
        
        <!-- Central decorative playful element (tethered dot and diamonds, tech/ticket notch style) -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex items-center gap-2 bg-[#001E2B] px-4">
            <span class="w-1.5 h-1.5 rounded-full bg-[#00ED64] shadow-[0_0_8px_#00ED64] opacity-60"></span>
            <div class="w-2.5 h-2.5 rotate-45 border border-[#00ED64]/60 bg-[#001E2B] flex items-center justify-center shadow-[0_0_8px_rgba(0,237,100,0.3)]">
                <span class="w-1 h-1 bg-[#00ED64] rounded-full"></span>
            </div>
            <span class="w-1.5 h-1.5 rounded-full bg-[#00ED64] shadow-[0_0_8px_#00ED64] opacity-60"></span>
        </div>

        <!-- Secondary Dashed Accent Line underneath -->
        <div class="w-[75%] h-[1px] mt-1.5 bg-gradient-to-r from-transparent via-[#00ED64]/20 to-transparent border-t border-dashed border-[#00ED64]/30"></div>
    </div>
    <div class="grid md:grid-cols-4 gap-12">
        <div class="col-span-2">
            <div class="font-bold text-2xl tracking-tighter mb-6">GrapA<span class="text-[#00ED64]">Tix</span></div>
            <p class="text-[#98A1A8] text-[14px] max-w-sm mb-8">
                Het grootste platform voor tech-events wereldwijd. Ontdek, leer en netwerk met de beste in de industrie.
            </p>
        </div>
        <div class="flex flex-col items-start md:items-center">
            <h4 class="font-bold text-[14px] uppercase tracking-wider mb-6 text-[#00ED64] text-left md:text-center w-full">Events</h4>
            <div class="flex gap-x-8 md:gap-x-12 text-[#98A1A8] text-[14px]">
                @foreach(\App\Models\Category::withoutGlobalScopes()->get()->chunk(3) as $chunk)
                    <ul class="space-y-4">
                        @foreach($chunk as $cat)
                            <li>
                                <a href="/?selectedCategory={{ $cat->slug }}#events-grid" 
                                   onclick="if (document.getElementById('events-grid')) { event.preventDefault(); Livewire.dispatch('category-selected', { categorySlug: '{{ $cat->slug }}' }); document.getElementById('events-grid').scrollIntoView({ behavior: 'smooth' }); history.pushState(null, '', '/?selectedCategory={{ $cat->slug }}'); }"
                                   class="hover:text-white transition-colors">
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            </div>
        </div>
        <div>
            <h4 class="font-bold text-[14px] uppercase tracking-wider mb-6 text-[#00ED64]">Platform</h4>
            <ul class="space-y-4 text-[#98A1A8] text-[14px]">
                <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">Over ons</a></li>
                <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact</a></li>
                <li><a href="{{ route('privacy') }}" class="hover:text-white transition-colors">Privacy Policy</a></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-[#3D4F58] mt-16 pt-8 flex justify-between items-center text-[#98A1A8] text-[12px]">
        <p>© {{ date('Y') }} GrapATix. Alle rechten voorbehouden.</p>
        <div class="flex gap-6">
            <a href="#" class="hover:text-white">Twitter</a>
            <a href="#" class="hover:text-white">LinkedIn</a>
            <a href="#" class="hover:text-white">GitHub</a>
        </div>
    </div>
</footer>
