@props(['inverted' => false, 'compact' => false])

<a href="{{ route('home') }}" {{ $attributes->class('group inline-flex items-center gap-2.5') }}>
    <span @class([
        'grid size-9 shrink-0 place-items-center rounded-[0.6rem] transition',
        'bg-ink-900 text-signal-400' => ! $inverted,
        'bg-white text-ink-900' => $inverted,
    ])>
        <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M4 17.5 9 12l3.5 3.5L20 7" />
            <circle cx="9" cy="12" r="1.6" fill="currentColor" stroke="none" />
            <circle cx="12.5" cy="15.5" r="1.6" fill="currentColor" stroke="none" />
        </svg>
    </span>
    @unless ($compact)
        <span @class([
            'font-display text-[1.0625rem] leading-none font-bold tracking-tight',
            'text-ink-900' => ! $inverted,
            'text-white' => $inverted,
        ])>
            AI Talent<span @class(['text-brand-600' => ! $inverted, 'text-signal-400' => $inverted]) >Hub</span>
        </span>
    @endunless
</a>
