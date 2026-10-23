@props(['label', 'value' => null, 'hint' => null, 'icon' => null, 'tone' => 'neutral'])

<div {{ $attributes->class('card flex flex-col gap-1 p-5') }}>
    <div class="flex items-center justify-between gap-2">
        <p class="text-sm font-medium text-ink-500">{{ $label }}</p>
        @if ($icon)
            <x-icon :name="$icon" class="size-4 text-ink-400" />
        @endif
    </div>
    <p class="num mt-1 text-2xl font-bold tracking-tight text-ink-900">{{ $value }}</p>
    @if ($hint)
        <p @class([
            'text-xs',
            'text-pass-700' => $tone === 'pass',
            'text-warn-700' => $tone === 'warn',
            'text-stop-700' => $tone === 'stop',
            'text-ink-500' => $tone === 'neutral',
        ])>{{ $hint }}</p>
    @endif
    {{ $slot }}
</div>
