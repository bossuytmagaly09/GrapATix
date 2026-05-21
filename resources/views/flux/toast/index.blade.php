@blaze(fold: true, safe: ['position'])

@props([
    'position' => 'bottom end',
])

<ui-toast x-data x-on:toast-show.document="! $el.closest('ui-toast-group') && $el.showToast($event.detail)" popover="manual" position="{{ $position }}" wire:ignore>
    <template>
        <div {{ $attributes->only(['class'])->class('max-w-md in-[ui-toast-group]:max-w-auto in-[ui-toast-group]:w-sm sm:in-[ui-toast-group]:w-md') }} data-variant="" data-flux-toast-dialog>
            <div class="p-4 flex rounded-xl shadow-lg shadow-[#00ED64]/10 bg-[#001E2B] border border-white/10 dark:bg-[#001E2B] dark:border-white/10">
                <div class="flex-1 flex items-start gap-4 overflow-hidden">
                    <div class="flex-1 py-1.5 ps-2.5 flex gap-3">
                        {{-- Success icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="hidden [[data-flux-toast-dialog][data-variant=success]_&]:block shrink-0 mt-0.5 size-5 text-[#00ED64]">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z" clip-rule="evenodd" />
                        </svg>

                        {{-- Warning icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="hidden [[data-flux-toast-dialog][data-variant=warning]_&]:block shrink-0 mt-0.5 size-5 text-amber-400">
                            <path fill-rule="evenodd" d="M6.701 2.25c.577-1 2.02-1 2.598 0l5.196 9a1.5 1.5 0 0 1-1.299 2.25H2.804a1.5 1.5 0 0 1-1.3-2.25l5.197-9ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 1 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>

                        {{-- Info icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="hidden [[data-flux-toast-dialog][data-variant=info]_&]:block shrink-0 mt-0.5 size-5 text-cyan-400">
                            <path fill-rule="evenodd" d="M15 8A7 7 0 1 1 1 8a7 7 0 0 1 14 0ZM9 5a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM6.75 8a.75.75 0 0 0 0 1.5h.75v1.75a.75.75 0 0 0 1.5 0v-2.5A.75.75 0 0 0 8.25 8h-1.5Z" clip-rule="evenodd" />
                        </svg>
                        
                        {{-- Danger icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="hidden [[data-flux-toast-dialog][data-variant=danger]_&]:block shrink-0 mt-0.5 size-5 text-rose-500">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                        </svg>

                        <div>
                            {{-- Heading --}}
                            <div class="font-bold text-base text-[#00ED64] dark:text-[#00ED64] uppercase tracking-wider [&:not(:empty)+div]:font-normal [&:not(:empty)+div]:text-white/70 [&:not(:empty)+div]:dark:text-white/70 [&:not(:empty)]:pb-2"><slot name="heading"></slot></div>

                            {{-- Text --}}
                            <div class="font-medium text-base text-white/90 dark:text-white/90"><slot name="text"></slot></div>
                        </div>
                    </div>

                    {{-- Close button --}}
                    <ui-close class="flex items-center">
                        <button type="button" class="inline-flex items-center font-medium justify-center gap-2 truncate disabled:opacity-50 dark:disabled:opacity-75 disabled:cursor-default h-10 text-base rounded-md w-10 bg-transparent hover:bg-[#00ED64]/10 text-white/50 hover:text-[#00ED64] transition-colors" as="button">
                            <div>
                                <svg class="[:where(&)]:size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z"></path>
                                </svg>
                            </div>
                        </button>
                    </ui-close>
                </div>
            </div>
        </div>
    </template>
</ui-toast>
