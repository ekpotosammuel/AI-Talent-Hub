@props(['value', 'label' => null, 'note' => null, 'tone' => null, 'max' => 100, 'bar' => null])

@php
    $value = (int) $value;
    $pct = max(0, min(100, (int) round($value / max(1, (int) $max) * 100)));
    $tone ??= $value >= 85 ? 'signal' : ($value >= 70 ? 'brand' : ($value >= 50 ? 'warn' : 'stop'));
    $fill = [
        'signal' => 'bg-signal-500',
        'brand' => 'bg-brand-500',
        'warn' => 'bg-warn-500',
        'stop' => 'bg-stop-500',
        'ink' => 'bg-ink-700',
    ][$tone];
@endphp

<div {{ $attributes->class('flex flex-col gap-1.5') }}>
    @if ($label)
        <div class="flex items-baseline justify-between gap-3">
            <span class="text-sm font-medium text-ink-700">{{ $label }}</span>
            <span class="num text-sm font-semibold text-ink-900">{{ $value }}@if ($max === 100)<span class="text-ink-400">/100</span>@endif</span>
        </div>
    @endif
    <div class="meter relative">
        <span class="{{ $fill }}" style="width: {{ $pct }}%"></span>
        @if ($bar !== null)
            <span class="absolute inset-y-[-3px] w-0.5 rounded-full bg-ink-900" style="left: {{ max(0, min(100, (int) $bar)) }}%" title="Bar: {{ $bar }}"></span>
        @endif
    </div>
    @if ($note)
        <p class="text-xs text-ink-500">{{ $note }}</p>
    @endif
</div>
