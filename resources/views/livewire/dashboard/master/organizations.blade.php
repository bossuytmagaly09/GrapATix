<div class="space-y-8 bg-[#001E2B] p-6 rounded-3xl border border-white/5 min-h-[85vh] text-white">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-white/5 pb-6">
        <div>
            <h1 class="text-3xl font-black uppercase tracking-tight text-[#00ED64]">
                Beheer <span class="text-white">Organisaties</span>
            </h1>
            <p class="text-white/60 text-sm mt-1">Registreer nieuwe tenants, pas subdomeinen aan en beheer platform-organisaties.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard.master') }}" class="px-4 py-2 bg-[#081621] border border-white/10 hover:border-[#00ED64]/50 rounded-xl text-xs font-bold uppercase tracking-wider transition-all text-white hover:scale-105">
                Dashboard
            </a>
            <a href="{{ route('dashboard.master.organizations') }}" class="px-4 py-2 bg-[#00ED64] text-[#001E2B] rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-md shadow-[#00ED64]/10 hover:scale-105">
                Organisaties
            </a>
            <a href="{{ route('dashboard.master.users') }}" class="px-4 py-2 bg-[#081621] border border-white/10 hover:border-[#00ED64]/50 rounded-xl text-xs font-bold uppercase tracking-wider transition-all text-white hover:scale-105">
                Gebruikers
            </a>
            <button wire:click="create" class="px-4 py-2 bg-[#00ED64]/10 hover:bg-[#00ED64] text-[#00ED64] hover:text-[#001E2B] border border-[#00ED64]/30 rounded-xl text-xs font-bold uppercase tracking-wider transition-all hover:scale-105 flex items-center gap-1.5 ml-2">
                <flux:icon icon="plus" class="size-4" />
                <span>Nieuw</span>
            </button>
        </div>
    </div>

    <!-- Organizations Table -->
    <div class="bg-[#081621] border border-white/5 rounded-2xl overflow-hidden shadow-xl">
        <div class="px-6 py-5 border-b border-white/5 bg-[#001E2B]/50 flex justify-between items-center">
            <div>
                <h2 class="font-bold text-lg text-white">Geregistreerde Organisaties (Tenants)</h2>
                <p class="text-white/50 text-xs mt-0.5">Totaal: {{ $organizations->count() }} geregistreerde partijen.</p>
            </div>
            <span class="bg-[#00ED64]/10 text-[#00ED64] text-[10px] font-bold px-3 py-1 rounded-full uppercase border border-[#00ED64]/20 tracking-wider">Multi-Tenant Setup</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-[#001E2B]/30 text-white/50 text-xs uppercase font-bold border-b border-white/5">
                    <tr>
                        <th class="px-6 py-4">Naam</th>
                        <th class="px-6 py-4">Subdomein / URL</th>
                        <th class="px-6 py-4 text-center">Evenementen</th>
                        <th class="px-6 py-4 text-center">Medewerkers</th>
                        <th class="px-6 py-4">Gemaakt op</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Acties</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($organizations as $org)
                        <tr class="hover:bg-white/[0.02] transition-colors text-sm {{ $org->trashed() ? 'opacity-50' : '' }}">
                            <td class="px-6 py-4 font-bold text-white flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-[#001E2B] flex items-center justify-center border border-white/5 font-black text-xs text-[#00ED64]">
                                    {{ substr($org->name, 0, 2) }}
                                </div>
                                <span class="{{ $org->trashed() ? 'line-through text-white/40' : 'text-white' }}">{{ $org->name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs text-white/60 bg-[#001E2B] border border-white/5 px-2.5 py-1 rounded-lg">
                                    {{ $org->subdomain }}.grapatix.be
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-blue-400">
                                <span class="bg-blue-500/10 border border-blue-500/20 px-2.5 py-0.5 rounded-lg text-xs">{{ $org->events_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-purple-400">
                                <span class="bg-purple-500/10 border border-purple-500/20 px-2.5 py-0.5 rounded-lg text-xs">{{ $org->users_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-white/50 text-xs">{{ $org->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4">
                                @if($org->trashed())
                                    <span class="bg-red-500/10 text-red-400 text-[10px] font-bold px-2.5 py-1 rounded-full border border-red-500/20">Gearchiveerd</span>
                                @else
                                    <span class="bg-[#00ED64]/10 text-[#00ED64] text-[10px] font-bold px-2.5 py-1 rounded-full border border-[#00ED64]/20">Actief</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right space-x-1.5">
                                @if($org->trashed())
                                    <button wire:click="restore({{ $org->id }})" class="p-1.5 bg-green-500/10 hover:bg-green-500 text-green-400 hover:text-white rounded-lg border border-green-500/20 transition-all text-xs font-bold px-2.5" title="Herstellen">
                                        Herstellen
                                    </button>
                                    <button wire:click="forceDelete({{ $org->id }})" wire:confirm="Weet u zeker dat u deze organisatie definitief wilt verwijderen? Dit kan niet ongedaan worden gemaakt!" class="p-1.5 bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white rounded-lg border border-red-500/20 transition-all text-xs font-bold px-2.5" title="Definitief Verwijderen">
                                        Definitief
                                    </button>
                                @else
                                    <button wire:click="edit({{ $org->id }})" class="p-1.5 bg-white/5 hover:bg-[#00ED64] text-white/80 hover:text-[#001E2B] rounded-lg border border-white/10 transition-all" title="Bewerken">
                                        <flux:icon icon="pencil-square" class="size-4" />
                                    </button>
                                    <button wire:click="delete({{ $org->id }})" wire:confirm="Weet u zeker dat u deze organisatie wilt archiveren?" class="p-1.5 bg-red-500/10 hover:bg-red-500 text-red-450 hover:text-white rounded-lg border border-red-500/20 transition-all" title="Archiveren">
                                        <flux:icon icon="archive-box" class="size-4" />
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-white/40">Geen organisaties gevonden in de database.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form (Create/Edit) -->
    <flux:modal name="organization-modal" class="bg-[#001E2B] text-white border border-white/10 md:w-[500px] rounded-2xl">
        <form wire:submit.prevent="save" class="space-y-6">
            <div>
                <flux:heading size="lg" class="text-[#00ED64] uppercase font-black tracking-tight">
                    {{ $editingOrganizationId ? 'Organisatie Bewerken' : 'Organisatie Toevoegen' }}
                </flux:heading>
                <flux:subheading class="text-white/60">Vul de basisgegevens in voor deze tenant.</flux:subheading>
            </div>

            <div class="space-y-4">
                <div>
                    <flux:label class="text-white/80 font-bold mb-1">Organisatie Naam</flux:label>
                    <flux:input wire:model="name" placeholder="bijv. Tomorrowland of KBVB" class="bg-[#081621] border-white/10 text-white rounded-xl focus:border-[#00ED64]" />
                    @error('name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label class="text-white/80 font-bold mb-1">Subdomein</flux:label>
                    <div class="flex items-center">
                        <flux:input wire:model="subdomain" placeholder="bijv. tomorrowland" class="bg-[#081621] border-white/10 text-white rounded-xl focus:border-[#00ED64] w-full" />
                        <span class="ml-2 text-white/40 text-xs font-mono">.grapatix.be</span>
                    </div>
                    <p class="text-white/40 text-[10px] mt-1">Alleen letters, cijfers en liggende streepjes (-). Alles wordt omgezet naar kleine letters.</p>
                    @error('subdomain') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
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
