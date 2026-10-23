@props(['initials', 'size' => 'size-10', 'tone' => 'brand'])

@php
    $tones = [
        'brand' => 'bg-brand-100 text-brand-700',
        'ink' => 'bg-ink-800 text-white',
        'signal' => 'bg-signal-200 text-signal-700',
        'paper' => 'bg-ink-100 text-ink-600',
    ];
@endphp

<span {{ $attributes->class("{$size} grid shrink-0 place-items-center rounded-full text-xs font-bold tracking-wide {$tones[$tone]}") }} aria-hidden="true">
    {{ $initials }}
</span>
