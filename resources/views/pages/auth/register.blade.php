<x-layouts.auth.split :title="__('Register')">
    <div class="space-y-12">
        <div>
            <h1 class="text-[72px] font-black leading-none tracking-tighter uppercase">Registreren</h1>
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

            <flux:button type="submit" variant="primary" class="w-full bg-[#00ED64] text-[#001E2B] font-black text-lg py-5 rounded-full shadow-[0_20px_40px_rgba(0,237,100,0.2)] hover:scale-[1.02] transition-transform">
                {{ __('Account aanmaken') }}
            </flux:button>
        </form>
    </div>
</x-layouts.auth.split>
