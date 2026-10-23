@props(['person'])

<article {{ $attributes->class('card cursor-grab p-3.5 shadow-xs transition active:cursor-grabbing hover:border-brand-300 hover:shadow-md') }} data-card>
    <div class="flex items-start gap-2.5">
        <x-avatar :initials="$person['initials']" tone="paper" size="size-9" />
        <div class="min-w-0 flex-1">
            <a href="{{ route('employer.candidates.show') }}" class="block truncate text-sm font-semibold text-ink-900 hover:text-brand-700">{{ $person['name'] }}</a>
            <p class="truncate text-xs text-ink-500">{{ $person['location'] }}</p>
        </div>
        <span class="num shrink-0 rounded-md bg-ink-900 px-1.5 py-0.5 text-xs font-bold text-signal-400">{{ $person['match'] }}</span>
    </div>

    <div class="mt-2.5 flex flex-wrap items-center gap-1.5">
        <x-badge :tone="$person['verified'] === $person['checks'] ? 'pass' : 'warn'" icon="shield">
            {{ $person['verified'] }}/{{ $person['checks'] }}
        </x-badge>
        @if ($person['ai_score'] !== null)
            <x-badge :tone="$person['ai_score'] >= 80 ? 'brand' : 'neutral'" icon="mic">{{ $person['ai_score'] }}</x-badge>
        @endif
    </div>

    <p class="mt-2 text-xs leading-relaxed text-ink-500">{{ $person['note'] }}</p>
</article>
