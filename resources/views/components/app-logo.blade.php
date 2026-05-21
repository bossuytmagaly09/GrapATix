@props([
    'sidebar' => false,
])

@php
    $platformName = 'Master Platform';
    if (auth()->check() && !auth()->user()->can('access-master-dashboard')) {
        $platformName = 'Organisatie Platform';
    }
@endphp

@if($sidebar)
    <a {{ $attributes }} class="flex items-center gap-2 px-2 py-1 mt-2 mb-4 group outline-none">
        <span class="text-xl font-black text-[#00ED64] tracking-widest uppercase group-hover:text-white transition-colors">
            {{ $platformName }}
        </span>
    </a>
@else
    <a {{ $attributes }} class="flex items-center gap-2 px-2 py-1 group outline-none">
        <span class="text-xl font-black text-[#00ED64] tracking-widest uppercase group-hover:text-white transition-colors">
            {{ $platformName }}
        </span>
    </a>
@endif
