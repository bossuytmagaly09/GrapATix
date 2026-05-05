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
                    <flux:table.row :key="$category->id">
                        <flux:table.cell class="font-medium">{{ $category->name }}</flux:table.cell>
                        <flux:table.cell>{{ $category->slug }}</flux:table.cell>
                        <flux:table.cell align="end">
                            <flux:button variant="ghost" icon="pencil-square" wire:click="edit({{ $category->id }})" />
                            <flux:button variant="ghost" icon="trash" wire:click="delete({{ $category->id }})" wire:confirm="{{ __('Are you sure you want to delete this category?') }}" />
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
