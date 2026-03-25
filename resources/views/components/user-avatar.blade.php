@props([
    'user' => null,
    'size' => 'md',
    'fallback' => '??',
    'bg' => 'bg-sky-100',
    'text' => 'text-sky-700',
])

@php
    $sizeClasses = [
        'sm' => 'h-10 w-10 text-xs',
        'md' => 'h-12 w-12 text-sm',
        'lg' => 'h-16 w-16 text-lg',
        'xl' => 'h-24 w-24 text-3xl',
        'header' => 'h-11 w-11 text-sm',
    ];

    $resolvedSize = $sizeClasses[$size] ?? $sizeClasses['md'];
    $initials = $user && method_exists($user, 'getInitials')
        ? $user->getInitials()
        : $fallback;
@endphp

<div {{ $attributes->merge(['class' => "{$resolvedSize} overflow-hidden rounded-full {$bg} {$text} border border-sky-200 flex items-center justify-center flex-shrink-0"]) }}>
    <span class="font-semibold leading-none">{{ $initials }}</span>
</div>
