@props(['label', 'name', 'hint' => null, 'required' => false])

<div {{ $attributes->class('flex flex-col gap-1.5') }}>
    <label for="{{ $name }}" class="text-sm font-medium text-ink-700">
        {{ $label }}
        @if ($required)
            <span class="text-stop-500" aria-hidden="true">*</span>
        @endif
    </label>
    {{ $slot }}
    @if ($hint)
        <p class="text-xs text-ink-500">{{ $hint }}</p>
    @endif
</div>
