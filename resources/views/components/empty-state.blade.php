@props(['title', 'description' => null, 'icon' => 'search'])

<div {{ $attributes->class('card flex flex-col items-center gap-3 px-6 py-14 text-center') }}>
    <span class="grid size-11 place-items-center rounded-full bg-ink-100 text-ink-500">
        <x-icon :name="$icon" />
    </span>
    <p class="font-semibold text-ink-900">{{ $title }}</p>
    @if ($description)
        <p class="max-w-md text-sm text-ink-500">{{ $description }}</p>
    @endif
    {{ $slot }}
</div>
