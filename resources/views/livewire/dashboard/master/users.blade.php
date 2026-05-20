<div class="space-y-8 bg-[#001E2B] p-6 rounded-3xl border border-white/5 min-h-[85vh] text-white">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-white/5 pb-6">
        <div>
            <h1 class="text-3xl font-black uppercase tracking-tight text-[#00ED64]">
                Beheer <span class="text-white">Gebruikers</span>
            </h1>
            <p class="text-white/60 text-sm mt-1">Beheer accounts, wijzig machtigingen en koppel medewerkers aan organisaties.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard.master') }}" class="px-4 py-2 bg-[#081621] border border-white/10 hover:border-[#00ED64]/50 rounded-xl text-xs font-bold uppercase tracking-wider transition-all text-white hover:scale-105">
                Dashboard
            </a>
            <a href="{{ route('dashboard.master.organizations') }}" class="px-4 py-2 bg-[#081621] border border-white/10 hover:border-[#00ED64]/50 rounded-xl text-xs font-bold uppercase tracking-wider transition-all text-white hover:scale-105">
                Organisaties
            </a>
            <a href="{{ route('dashboard.master.users') }}" class="px-4 py-2 bg-[#00ED64] text-[#001E2B] rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-md shadow-[#00ED64]/10 hover:scale-105">
                Gebruikers
            </a>
            <button wire:click="create" class="px-4 py-2 bg-[#00ED64]/10 hover:bg-[#00ED64] text-[#00ED64] hover:text-[#001E2B] border border-[#00ED64]/30 rounded-xl text-xs font-bold uppercase tracking-wider transition-all hover:scale-105 flex items-center gap-1.5 ml-2">
                <flux:icon icon="plus" class="size-4" />
                <span>Nieuw</span>
            </button>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-[#081621] border border-white/5 rounded-2xl overflow-hidden shadow-xl">
        <div class="px-6 py-5 border-b border-white/5 bg-[#001E2B]/50 flex justify-between items-center">
            <div>
                <h2 class="font-bold text-lg text-white">Geregistreerde Accounts</h2>
                <p class="text-white/50 text-xs mt-0.5">Totaal: {{ $users->count() }} accounts geregistreerd op het platform.</p>
            </div>
            <span class="bg-[#00ED64]/10 text-[#00ED64] text-[10px] font-bold px-3 py-1 rounded-full uppercase border border-[#00ED64]/20 tracking-wider">Gebruikersbeheer</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-[#001E2B]/30 text-white/50 text-xs uppercase font-bold border-b border-white/5">
                    <tr>
                        <th class="px-6 py-4">Naam / Initials</th>
                        <th class="px-6 py-4">E-mailadres</th>
                        <th class="px-6 py-4">Koppeling</th>
                        <th class="px-6 py-4">Machtigingsrol</th>
                        <th class="px-6 py-4">Geregistreerd</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Acties</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($users as $user)
                        @php
                            $isMasterAdmin = $user->id === 1 || str_ends_with($user->email, '@grapatix.be');
                        @endphp
                        <tr class="hover:bg-white/[0.02] transition-colors text-sm {{ $user->trashed() ? 'opacity-50' : '' }}">
                            <td class="px-6 py-4 font-bold text-white flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-[#001E2B] flex items-center justify-center border border-white/10 font-bold text-xs text-[#00ED64] shrink-0">
                                    {{ $user->initials() }}
                                </div>
                                <div>
                                    <span class="{{ $user->trashed() ? 'line-through text-white/40' : 'text-white' }}">{{ $user->name }}</span>
                                    @if($user->id === auth()->id())
                                        <span class="text-[9px] bg-white/10 text-white font-bold ml-1.5 px-1.5 py-0.5 rounded border border-white/10">Jij</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-white/70">{{ $user->email }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->organization)
                                    <span class="text-blue-400 font-semibold flex items-center gap-1">
                                        <flux:icon icon="building-office-2" class="size-4 shrink-0" />
                                        <span class="truncate max-w-[150px]" title="{{ $user->organization->name }}">{{ $user->organization->name }}</span>
                                    </span>
                                @else
                                    <span class="text-white/30 text-xs italic">Geen (Platform koper)</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($isMasterAdmin)
                                    <span class="bg-[#00ED64]/10 text-[#00ED64] text-[10px] font-bold px-2.5 py-0.5 rounded-full border border-[#00ED64]/20 flex items-center gap-1 w-fit">
                                        <span>👑</span> Master Admin
                                    </span>
                                @elseif($user->organization)
                                    <span class="bg-blue-500/10 text-blue-400 text-[10px] font-bold px-2.5 py-0.5 rounded-full border border-blue-500/20 flex items-center gap-1 w-fit">
                                        <span>🏢</span> Organisatie Lid
                                    </span>
                                @else
                                    <span class="bg-white/5 text-white/60 text-[10px] font-bold px-2.5 py-0.5 rounded-full border border-white/10 flex items-center gap-1 w-fit">
                                        <span>👤</span> Klant
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-white/50 text-xs">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                @if($user->trashed())
                                    <span class="bg-red-500/10 text-red-400 text-[10px] font-bold px-2.5 py-1 rounded-full border border-red-500/20">Gearchiveerd</span>
                                @else
                                    <span class="bg-[#00ED64]/10 text-[#00ED64] text-[10px] font-bold px-2.5 py-1 rounded-full border border-[#00ED64]/20">Actief</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-1.5">
                                @if($user->trashed())
                                    <button wire:click="restore({{ $user->id }})" class="p-1.5 bg-green-500/10 hover:bg-green-500 text-green-400 hover:text-white rounded-lg border border-green-500/20 transition-all text-xs font-bold px-2.5" title="Herstellen">
                                        Herstellen
                                    </button>
                                    <button wire:click="forceDelete({{ $user->id }})" wire:confirm="Weet u zeker dat u deze gebruiker definitief wilt verwijderen? Dit kan niet ongedaan worden gemaakt!" class="p-1.5 bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white rounded-lg border border-red-500/20 transition-all text-xs font-bold px-2.5" title="Definitief Verwijderen">
                                        Definitief
                                    </button>
                                @else
                                    <button wire:click="edit({{ $user->id }})" class="p-1.5 bg-white/5 hover:bg-[#00ED64] text-white/80 hover:text-[#001E2B] rounded-lg border border-white/10 transition-all" title="Bewerken">
                                        <flux:icon icon="pencil-square" class="size-4" />
                                    </button>
                                    @if($user->id !== auth()->id())
                                        <button wire:click="delete({{ $user->id }})" wire:confirm="Weet u zeker dat u deze gebruiker wilt archiveren?" class="p-1.5 bg-red-500/10 hover:bg-red-500 text-red-450 hover:text-white rounded-lg border border-red-500/20 transition-all" title="Archiveren">
                                            <flux:icon icon="archive-box" class="size-4" />
                                        </button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-white/40">Geen gebruikers gevonden in de database.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form (Create/Edit) -->
    <flux:modal name="user-modal" class="bg-[#001E2B] text-white border border-white/10 md:w-[500px] rounded-2xl">
        <form wire:submit.prevent="save" class="space-y-6">
            <div>
                <flux:heading size="lg" class="text-[#00ED64] uppercase font-black tracking-tight">
                    {{ $editingUserId ? 'Gebruiker Bewerken' : 'Gebruiker Toevoegen' }}
                </flux:heading>
                <flux:subheading class="text-white/60">Vul de profielgegevens en machtigingen van de gebruiker in.</flux:subheading>
            </div>

            <div class="space-y-4">
                <div>
                    <flux:label class="text-white/80 font-bold mb-1">Volledige Naam</flux:label>
                    <flux:input wire:model="name" placeholder="bijv. Jan Janssens" class="bg-[#081621] border-white/10 text-white rounded-xl focus:border-[#00ED64]" />
                    @error('name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label class="text-white/80 font-bold mb-1">E-mailadres</flux:label>
                    <flux:input wire:model="email" type="email" placeholder="bijv. jan@grapatix.be of jan@gmail.com" class="bg-[#081621] border-white/10 text-white rounded-xl focus:border-[#00ED64]" />
                    <p class="text-white/40 text-[9px] mt-1">Let op: E-mailadressen eindigend op <span class="font-mono">@grapatix.be</span> krijgen automatisch Master Admin toegang.</p>
                    @error('email') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label class="text-white/80 font-bold mb-1">
                        {{ $editingUserId ? 'Nieuw Wachtwoord (Optioneel)' : 'Wachtwoord' }}
                    </flux:label>
                    <flux:input wire:model="password" type="password" placeholder="{{ $editingUserId ? 'Leeg laten om niet te wijzigen' : 'Minimaal 8 tekens' }}" class="bg-[#081621] border-white/10 text-white rounded-xl focus:border-[#00ED64]" />
                    @error('password') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label class="text-white/80 font-bold mb-1">Koppeling aan Organisatie</flux:label>
                    <flux:select wire:model="organization_id" placeholder="Selecteer een organisatie (Optioneel)..." class="bg-[#081621] border-white/10 text-white rounded-xl focus:border-[#00ED64]">
                        <flux:select.option value="">Geen (Platform koper / Master Admin)</flux:select.option>
                        @foreach($organizations as $org)
                            <flux:select.option value="{{ $org->id }}">{{ $org->name }} ({{ $org->subdomain }})</flux:select.option>
                        @endforeach
                    </flux:select>
                    @error('organization_id') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 border-t border-white/5 pt-4">
                <flux:modal.close>
                    <button type="button" class="px-4 py-2 bg-[#081621] border border-white/10 hover:border-white/20 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all">
                        Annuleren
                    </button>
                </flux:modal.close>
                <button type="submit" class="px-4 py-2 bg-[#00ED64] text-[#001E2B] rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-md shadow-[#00ED64]/10 hover:scale-105">
                    Opslaan
                </button>
            </div>
        </form>
    </flux:modal>
</div>
