<x-layouts.auth.split :title="__('Log in')">
    <div class="space-y-12">
        <div>
            <h1 class="text-[72px] font-black text-white leading-none tracking-tighter uppercase">Login</h1>
            <p class="text-[#98A1A8] text-lg mt-4">Voer je gegevens in om verder te gaan</p>
        </div>

        <x-auth-session-status :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="space-y-10">
            @csrf

            <flux:input
                name="email"
                :label="__('E-mailadres')"
                type="email"
                required
                class="flux-underline"
            />

            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('Wachtwoord')"
                    type="password"
                    required
                    viewable
                    class="flux-underline"
                />
                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 end-0 text-xs text-[#00ED64]" :href="route('password.request')" wire:navigate>
                        {{ __('Vergeten?') }}
                    </flux:link>
                @endif
            </div>

            <flux:button variant="primary" type="submit" class="w-full bg-[#00ED64] text-[#001E2B] font-black text-lg py-5 rounded-full shadow-[0_20px_40px_rgba(0,237,100,0.2)] hover:scale-[1.02] transition-transform">
                {{ __('Inloggen') }}
            </flux:button>
        </form>
    </div>
</x-layouts.auth.split>
