{{-- Marks every screen in this build as an interface mockup rather than a working feature. --}}
<p {{ $attributes->class('flex items-start gap-2 rounded-lg border border-dashed border-ink-300 bg-ink-100/60 px-3 py-2 text-xs text-ink-500') }}>
    <x-icon name="alert" class="mt-px size-3.5 shrink-0" />
    <span>{{ $slot }}</span>
</p>
