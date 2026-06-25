<div>
    @if($usesCategories)
    <div class="flex flex-col gap-6">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">{{ __('Categories') }}</flux:heading>
                <flux:subheading>{{ __('Manage your event categories.') }}</flux:subheading>
            </div>
            <flux:button icon="plus" variant="primary" wire:click="create">{{ __('Add Category') }}</flux:button>
        </div>

        <flux:card class="overflow-hidden">
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>{{ __('Name') }}</flux:table.column>
                    <flux:table.column>{{ __('Slug') }}</flux:table.column>
                    <flux:table.column align="end">{{ __('Actions') }}</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach ($categories as $category)
                        <flux:table.row :key="$category->id" class="{{ $category->trashed() ? 'opacity-60 bg-red-500/5' : '' }}">
                            <flux:table.cell class="font-medium {{ $category->trashed() ? 'line-through' : '' }}">{{ $category->name }}</flux:table.cell>
                            <flux:table.cell>
                                {{ $category->slug }}
                                @if($category->trashed())
                                    <flux:badge size="sm" color="red" class="ml-2">Verwijderd</flux:badge>
                                @endif
                            </flux:table.cell>
                            <flux:table.cell align="end">
                                @if($category->trashed())
                                    <flux:button variant="ghost" icon="arrow-uturn-left" wire:click="restore({{ $category->id }})" wire:confirm="Weet je zeker dat je deze categorie wil herstellen?" />
                                @else
                                    <flux:button variant="ghost" icon="pencil-square" wire:click="edit({{ $category->id }})" />
                                    <flux:button variant="ghost" icon="trash" wire:click="delete({{ $category->id }})" wire:confirm="{{ __('Are you sure you want to delete this category?') }}" />
                                @endif
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </flux:card>

        <flux:modal name="category-modal" class="md:w-[500px]">
            <form wire:submit="save" class="space-y-6">
                <div>
                    <flux:heading size="lg">{{ $editingCategoryId ? __('Edit Category') : __('Add Category') }}</flux:heading>
                    <flux:subheading>{{ __('Enter the details for this category.') }}</flux:subheading>
                </div>

                <div class="space-y-4">
                    <flux:input wire:model.live="name" :label="__('Name')" placeholder="e.g. Concerts" />
                    <flux:input wire:model="slug" :label="__('Slug')" />
                </div>

                <div class="flex justify-end gap-2">
                    <flux:modal.close>
                        <flux:button variant="ghost">{{ __('Cancel') }}</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
                </div>
            </form>
        </flux:modal>
    </div>
    @else
    <div class="flex flex-col items-center justify-center min-h-[60vh] text-center p-8 bg-[#081621] border border-white/5 rounded-3xl space-y-6">
        <div class="w-16 h-16 rounded-2xl bg-[#00ED64]/10 border border-[#00ED64]/30 flex items-center justify-center shadow-[0_0_15px_rgba(0,237,100,0.1)]">
            <flux:icon icon="tag" class="size-8 text-[#00ED64]" />
        </div>
        
        <div class="space-y-2 max-w-md">
            <h2 class="text-2xl font-black uppercase tracking-tight text-white">
                Categorieën staan <span class="text-[#00ED64]">Uit</span>
            </h2>
            <p class="text-[#98A1A8] text-sm leading-relaxed">
                Op dit moment is de categorie-functionaliteit uitgeschakeld voor jouw organisatie. Activeer dit om evenementen te groeperen en een categoriefilter op je website te tonen.
            </p>
        </div>
        
        <button wire:click="enableCategories" class="px-6 py-3.5 bg-[#00ED64] text-[#001E2B] rounded-xl text-sm font-black uppercase tracking-wider transition-all shadow-md shadow-[#00ED64]/20 hover:scale-105 active:scale-95 cursor-pointer">
            Categorieën Activeren
        </button>
    </div>
    @endif
</div>
