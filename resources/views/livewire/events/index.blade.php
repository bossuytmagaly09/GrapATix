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
                <flux:table.column>{{ __('Title') }}</flux:table.column>
                <flux:table.column>{{ __('Category') }}</flux:table.column>
                <flux:table.column>{{ __('Date') }}</flux:table.column>
                <flux:table.column>{{ __('Price') }}</flux:table.column>
                <flux:table.column align="end">{{ __('Actions') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($events as $event)
                    <flux:table.row :key="$event->id">
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

                <flux:textarea wire:model="description" :label="__('Description')" placeholder="{{ __('Describe your event...') }}" />
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
