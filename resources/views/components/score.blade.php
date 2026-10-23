@props(['value', 'label' => null, 'size' => 112, 'tone' => null, 'caption' => null])

@php
    $value = (int) $value;
    $tone ??= $value >= 85 ? 'signal' : ($value >= 70 ? 'brand' : ($value >= 50 ? 'warn' : 'stop'));
    $stroke = [
        'signal' => 'var(--color-signal-500)',
        'brand' => 'var(--color-brand-500)',
        'warn' => 'var(--color-warn-500)',
        'stop' => 'var(--color-stop-500)',
    ][$tone];

    $radius = 42;
    $circumference = 2 * M_PI * $radius;
    $offset = $circumference * (1 - min($value, 100) / 100);
@endphp

<div {{ $attributes->class('inline-flex flex-col items-center gap-1.5') }}>
    <div class="relative" style="width: {{ $size }}px; height: {{ $size }}px">
        <svg viewBox="0 0 100 100" class="size-full -rotate-90" role="img" aria-label="{{ $label ?? 'Score' }} {{ $value }} out of 100">
            <circle cx="50" cy="50" r="{{ $radius }}" fill="none" stroke="currentColor" stroke-width="8" class="text-ink-200" />
            <circle cx="50" cy="50" r="{{ $radius }}" fill="none" stroke="{{ $stroke }}" stroke-width="8" stroke-linecap="round"
                stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $offset }}" />
        </svg>
        <span class="absolute inset-0 grid place-items-center">
            <span class="num text-2xl font-bold tracking-tight" style="font-size: {{ max(18, (int) ($size / 4.2)) }}px">{{ $value }}</span>
        </span>
    </div>
    @if ($label)
        <span class="text-xs font-semibold text-ink-600">{{ $label }}</span>
    @endif
    @if ($caption)
        <span class="text-xs text-ink-500">{{ $caption }}</span>
    @endif
</div>
