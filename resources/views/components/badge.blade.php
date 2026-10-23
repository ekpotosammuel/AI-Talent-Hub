@props(['tone' => 'neutral', 'icon' => null])

@php
    $tones = [
        'neutral' => 'bg-ink-100 text-ink-700 ring-ink-200',
        'brand' => 'bg-brand-50 text-brand-700 ring-brand-200',
        'ink' => 'bg-ink-900 text-white ring-ink-900',
        'signal' => 'bg-signal-200 text-signal-700 ring-signal-300',
        'pass' => 'bg-pass-50 text-pass-700 ring-pass-500/30',
        'warn' => 'bg-warn-50 text-warn-700 ring-warn-500/30',
        'stop' => 'bg-stop-50 text-stop-700 ring-stop-500/30',
        'glass' => 'bg-white/10 text-white ring-white/20',
    ];
@endphp

<span {{ $attributes->class("inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset {$tones[$tone]}") }}>
    @if ($icon)
        <x-icon :name="$icon" class="size-3.5" />
    @endif
    {{ $slot }}
</span>
