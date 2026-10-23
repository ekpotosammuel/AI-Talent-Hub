@props(['active' => false])

<a {{ $attributes->class([
    'inline-flex items-center rounded-lg px-3 py-2 text-sm font-medium transition',
    'bg-ink-100 text-ink-900' => $active,
    'text-ink-600 hover:bg-ink-100 hover:text-ink-900' => ! $active,
]) }}>{{ $slot }}</a>
