<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-[#081621] text-white selection:bg-[#00ED64] selection:text-[#001E2B]">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-white/5 bg-[#001E2B]">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden text-white/50 hover:text-white" />
            </flux:sidebar.header>

        @cannot('access-master-dashboard')
            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid text-white/50">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate class="hover:text-[#00ED64] hover:bg-[#00ED64]/10 {{ request()->routeIs('dashboard') ? 'text-[#00ED64] bg-[#00ED64]/10' : 'text-white/80' }}">
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>

                    @if(auth()->user()->organization)
                    <flux:sidebar.item icon="tag" :href="route('categories.index')" :current="request()->routeIs('categories.index')" wire:navigate class="hover:text-[#00ED64] hover:bg-[#00ED64]/10 {{ request()->routeIs('categories.index') ? 'text-[#00ED64] bg-[#00ED64]/10' : 'text-white/80' }}">
                        {{ __('Categories') }}
                    </flux:sidebar.item>
                    @endif

                    <flux:sidebar.item icon="calendar" :href="route('events.index')" :current="request()->routeIs('events.index')" wire:navigate class="hover:text-[#00ED64] hover:bg-[#00ED64]/10 {{ request()->routeIs('events.index') ? 'text-[#00ED64] bg-[#00ED64]/10' : 'text-white/80' }}">
                        {{ __('Events') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="credit-card" :href="route('orders.index')" :current="request()->routeIs('orders.index')" wire:navigate class="hover:text-[#00ED64] hover:bg-[#00ED64]/10 {{ request()->routeIs('orders.index') ? 'text-[#00ED64] bg-[#00ED64]/10' : 'text-white/80' }}">
                        {{ __('Bestellingen') }}
                    </flux:sidebar.item>
                    
                    <flux:sidebar.item icon="cog-8-tooth" :href="route('tenant.settings')" :current="request()->routeIs('tenant.settings')" wire:navigate class="hover:text-[#00ED64] hover:bg-[#00ED64]/10 {{ request()->routeIs('tenant.settings') ? 'text-[#00ED64] bg-[#00ED64]/10' : 'text-white/80' }}">
                        {{ __('Instellingen') }}
                    </flux:sidebar.item>
                    
                    <div class="my-2 border-t border-white/10"></div>
                    
                    <flux:sidebar.item icon="globe-alt" :href="route('home')" target="_blank" class="hover:text-[#00ED64] hover:bg-[#00ED64]/10 text-white/80">
                        Naar de Site
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>
            @endcannot

            @can('access-master-dashboard')
                <flux:sidebar.nav>
                    <flux:sidebar.group heading="Platform Beheer" class="grid text-white/50">
                        <flux:sidebar.item icon="shield-check" :href="route('dashboard.master')" :current="request()->routeIs('dashboard.master')" wire:navigate class="hover:text-[#00ED64] hover:bg-[#00ED64]/10 {{ request()->routeIs('dashboard.master') ? 'text-[#00ED64] bg-[#00ED64]/10' : 'text-white/80' }}">
                            Master Panel
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="building-office-2" :href="route('dashboard.master.organizations')" :current="request()->routeIs('dashboard.master.organizations') || request()->routeIs('dashboard.master.organizations.*')" wire:navigate class="hover:text-[#00ED64] hover:bg-[#00ED64]/10 {{ request()->routeIs('dashboard.master.organizations') || request()->routeIs('dashboard.master.organizations.*') ? 'text-[#00ED64] bg-[#00ED64]/10' : 'text-white/80' }}">
                            Organisaties
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="users" :href="route('dashboard.master.users')" :current="request()->routeIs('dashboard.master.users') || request()->routeIs('dashboard.master.users.*')" wire:navigate class="hover:text-[#00ED64] hover:bg-[#00ED64]/10 {{ request()->routeIs('dashboard.master.users') || request()->routeIs('dashboard.master.users.*') ? 'text-[#00ED64] bg-[#00ED64]/10' : 'text-white/80' }}">
                            Gebruikers
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="credit-card" :href="route('dashboard.master.orders')" :current="request()->routeIs('dashboard.master.orders')" wire:navigate class="hover:text-[#00ED64] hover:bg-[#00ED64]/10 {{ request()->routeIs('dashboard.master.orders') ? 'text-[#00ED64] bg-[#00ED64]/10' : 'text-white/80' }}">
                            Bestellingen
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="banknotes" :href="route('dashboard.master.finances')" :current="request()->routeIs('dashboard.master.finances')" wire:navigate class="hover:text-[#00ED64] hover:bg-[#00ED64]/10 {{ request()->routeIs('dashboard.master.finances') ? 'text-[#00ED64] bg-[#00ED64]/10' : 'text-white/80' }}">
                            Financiën
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="cog-8-tooth" :href="route('dashboard.master.settings')" :current="request()->routeIs('dashboard.master.settings')" wire:navigate class="hover:text-[#00ED64] hover:bg-[#00ED64]/10 {{ request()->routeIs('dashboard.master.settings') ? 'text-[#00ED64] bg-[#00ED64]/10' : 'text-white/80' }}">
                            Instellingen
                        </flux:sidebar.item>
                        
                        <div class="my-2 border-t border-white/10"></div>
                        
                        <flux:sidebar.item icon="globe-alt" :href="route('home')" target="_blank" class="hover:text-[#00ED64] hover:bg-[#00ED64]/10 text-white/80">
                            Naar de Site
                        </flux:sidebar.item>
                    </flux:sidebar.group>
                </flux:sidebar.nav>
            @endcan

            <flux:spacer />

            <x-desktop-user-menu class="hidden lg:block text-white" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
