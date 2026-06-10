<x-layouts.auth.split :title="__('Register')">
    <div class="space-y-12">
        <div>
            <h1 class="text-5xl md:text-[72px] font-black leading-none tracking-tighter uppercase">Registreren</h1>
            <p class="text-lg mt-4 opacity-70">Maak je GrapATix account aan</p>
        </div>

        <form method="POST" action="{{ route('register.store') }}" class="space-y-6">
            @csrf
            
            <flux:input
                name="name"
                :label="__('Naam')"
                type="text"
                required
                class="flux-underline"
            />

            <flux:input
                name="email"
                :label="__('E-mailadres')"
                type="email"
                required
                class="flux-underline"
            />

            <flux:input
                name="password"
                :label="__('Wachtwoord')"
                type="password"
                required
                viewable
                class="flux-underline"
            />

            <flux:input
                name="password_confirmation"
                :label="__('Bevestig wachtwoord')"
                type="password"
                required
                viewable
                class="flux-underline"
            />

            <!-- Tenant Registration Toggle -->
            <div x-data="{ isTenant: false }" class="space-y-4 pt-2">
                <div class="flex items-center gap-2 bg-white/5 p-3 rounded-xl border border-white/10">
                    <input type="checkbox" id="register_as_organization_split" name="register_as_organization" value="1" x-model="isTenant" class="rounded text-[#00ED64] focus:ring-[#00ED64] bg-transparent border-white/20">
                    <label for="register_as_organization_split" class="text-xs font-bold text-white uppercase tracking-wider cursor-pointer select-none">Registreer als Organisatie</label>
                </div>

                <div x-show="isTenant" x-transition class="space-y-4 border-l-2 border-[#00ED64] pl-4">
                    <flux:input name="organization_name" :label="__('Organisatie Naam')" type="text" ::required="isTenant" class="flux-underline" />
                    <flux:input name="subdomain" :label="__('Gewenst Subdomein')" type="text" ::required="isTenant" class="flux-underline" placeholder="bijv. tomorrowland" />
                </div>
            </div>

            <flux:button type="submit" variant="primary" class="w-full bg-[#00ED64] text-[#001E2B] font-black text-lg py-5 rounded-full shadow-[0_20px_40px_rgba(0,237,100,0.2)] hover:scale-[1.02] transition-transform">
                {{ __('Account aanmaken') }}
            </flux:button>
        </form>
    </div>
</x-layouts.auth.split>
