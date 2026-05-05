<div class="flex flex-col gap-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl">{{ __('Events') }}</flux:heading>
            <flux:subheading>{{ __('Manage your upcoming events.') }}</flux:subheading>
        </div>
        <flux:button icon="plus" variant="primary" wire:click="create">{{ __('Add Event') }}</flux:button>
    </div>

    <flux:card class="overflow-hidden">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>{{ __('Image') }}</flux:table.column>
                <flux:table.column>{{ __('Title') }}</flux:table.column>
                <flux:table.column>{{ __('Category') }}</flux:table.column>
                <flux:table.column>{{ __('Date') }}</flux:table.column>
                <flux:table.column>{{ __('Price') }}</flux:table.column>
                <flux:table.column align="end">{{ __('Actions') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($events as $event)
                    <flux:table.row :key="$event->id">
                        <flux:table.cell>
                            @if($url = $event->getFirstMediaUrl('cover'))
                                <img src="{{ $url }}" class="w-12 h-8 object-cover rounded shadow-sm border border-zinc-200 dark:border-zinc-700">
                            @else
                                <div class="w-12 h-8 bg-zinc-100 dark:bg-zinc-800 rounded border border-dashed border-zinc-300 dark:border-zinc-600 flex items-center justify-center">
                                    <flux:icon icon="photo" class="size-4 text-zinc-400" />
                                </div>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell class="font-medium">{{ $event->title }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:badge size="sm" inset="top bottom">{{ $event->category?->name ?? __('Uncategorized') }}</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="text-sm">
                                <div>{{ $event->start_date?->format('d M Y, H:i') }}</div>
                                <div class="text-zinc-500">{{ $event->end_date?->format('d M Y, H:i') }}</div>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            €{{ number_format($event->price_cents / 100, 2, ',', '.') }}
                        </flux:table.cell>
                        <flux:table.cell align="end">
                            <flux:button variant="ghost" icon="pencil-square" wire:click="edit({{ $event->id }})" />
                            <flux:button variant="ghost" icon="trash" wire:click="delete({{ $event->id }})" wire:confirm="{{ __('Are you sure you want to delete this event?') }}" />
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:card>

    <flux:modal name="event-modal" class="md:w-[600px]">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $editingEventId ? __('Edit Event') : __('Add Event') }}</flux:heading>
                <flux:subheading>{{ __('Fill in the details for your event.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                <flux:input wire:model="title" :label="__('Title')" placeholder="e.g. Summer Festival 2026" />
                
                <flux:select wire:model="category_id" :label="__('Category')" placeholder="{{ __('Select a category...') }}">
                    @foreach ($categories as $category)
                        <flux:select.option :value="$category->id">{{ $category->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <div class="grid grid-cols-2 gap-4">
                    <flux:input type="datetime-local" wire:model="start_date" :label="__('Start Date')" />
                    <flux:input type="datetime-local" wire:model="end_date" :label="__('End Date')" />
                </div>

                <flux:input type="number" step="0.01" wire:model="price" :label="__('Price (€)')" icon="currency-euro" placeholder="0.00" />

                <!-- Image Upload -->
                <div class="space-y-2">
                    <flux:label>{{ __('Cover Image') }}</flux:label>
                    <input type="file" wire:model="image" class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-zinc-100 file:text-zinc-700 hover:file:bg-zinc-200 dark:file:bg-zinc-700 dark:file:text-zinc-300" />
                    
                    @if ($image)
                        <div class="mt-2 relative w-32 h-20 overflow-hidden rounded-lg border border-zinc-200">
                            <img src="{{ $image->temporaryUrl() }}" class="object-cover w-full h-full">
                        </div>
                    @elseif ($editingEventId && ($existingEvent = \App\Models\Event::find($editingEventId)) && $existingEvent->hasMedia('cover'))
                        <div class="mt-2 relative w-32 h-20 overflow-hidden rounded-lg border border-zinc-200">
                            <img src="{{ $existingEvent->getFirstMediaUrl('cover') }}" class="object-cover w-full h-full">
                        </div>
                    @endif
                </div>

                <!-- Rich Text Editor (Trix) -->
                <div class="space-y-2" wire:ignore>
                    <flux:label>{{ __('Description') }}</flux:label>
                    <input id="description" type="hidden" name="description" value="{{ $description }}">
                    <trix-editor 
                        input="description" 
                        class="block w-full p-2 border border-zinc-200 rounded-lg dark:border-zinc-700 dark:bg-zinc-800 trix-content"
                        x-on:trix-change="$wire.description = $event.target.value"
                    ></trix-editor>
                </div>

                <flux:separator />

                <div class="space-y-4">
                    <flux:heading size="sm">{{ __('SEO (Search Engine Optimization)') }}</flux:heading>
                    <flux:input wire:model="seo_title" :label="__('SEO Title')" placeholder="{{ __('Meta title for Google...') }}" />
                    <flux:textarea wire:model="seo_description" :label="__('SEO Description')" placeholder="{{ __('Meta description for Google...') }}" />
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary">{{ __('Save Event') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
