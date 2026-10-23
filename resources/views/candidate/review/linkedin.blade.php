<x-layouts.app title="LinkedIn review" side="candidate">
    <x-page-header title="Document review" description="Eight checks on how findable and how convincing your profile is." eyebrow="Candidate side">
        <x-slot:actions>
            <button type="button" class="btn btn-secondary btn-sm">
                <x-icon name="link" class="size-4" />
                Re-scan profile
            </button>
        </x-slot:actions>
    </x-page-header>

    @include('candidate.review._tabs')

    <div class="grid gap-5 lg:grid-cols-[22rem_1fr] lg:items-start">
        <div class="card flex flex-col gap-5 p-6">
            <div class="flex items-center gap-4">
                <x-score :value="$review['overall']" :size="104" label="Overall" />
                <div class="min-w-0 flex-1">
                    <p class="num text-sm font-semibold text-signal-700">▲ {{ $review['overall'] - $review['previous'] }} since the rewrite</p>
                    <p class="mt-1 text-xs text-ink-500">{{ $review['uploaded'] }}</p>
                    <p class="num mt-2 truncate text-xs text-brand-700">{{ $review['url'] }}</p>
                </div>
            </div>

            <p class="rounded-lg bg-ink-900 p-4 text-sm leading-relaxed text-white">{{ $review['verdict'] }}</p>
        </div>

        <div class="flex min-w-0 flex-col gap-5">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($review['metrics'] as $metric)
                    <x-stat :label="$metric['label']" :value="$metric['value']" :hint="$metric['change'].' · '.$metric['hint']" tone="pass" icon="arrow-up" />
                @endforeach
            </div>

            <div class="card overflow-hidden">
                <div class="flex items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
                    <h2 class="font-semibold text-ink-900">Profile checks</h2>
                    <div class="flex gap-1.5">
                        <x-badge tone="pass">{{ collect($review['checks'])->where('status', 'pass')->count() }} pass</x-badge>
                        <x-badge tone="warn">{{ collect($review['checks'])->where('status', 'warn')->count() }} fix</x-badge>
                        <x-badge tone="stop">{{ collect($review['checks'])->where('status', 'fail')->count() }} missing</x-badge>
                    </div>
                </div>

                <ul class="divide-y divide-ink-100">
                    @foreach ($review['checks'] as $check)
                        <li class="flex items-start gap-3.5 px-5 py-4">
                            <span @class([
                                'mt-0.5 grid size-6 shrink-0 place-items-center rounded-full',
                                'bg-pass-50 text-pass-700' => $check['status'] === 'pass',
                                'bg-warn-50 text-warn-700' => $check['status'] === 'warn',
                                'bg-stop-50 text-stop-700' => $check['status'] === 'fail',
                            ])>
                                <x-icon :name="match ($check['status']) { 'pass' => 'check', 'warn' => 'alert', default => 'x' }" class="size-3.5" />
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="font-medium text-ink-900">{{ $check['area'] }}</p>
                                <p class="mt-0.5 text-sm leading-relaxed text-ink-600">{{ $check['note'] }}</p>
                            </div>
                            @if ($check['status'] !== 'pass')
                                <button type="button" class="btn btn-secondary btn-sm shrink-0">Fix</button>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <x-mockup-note>Mockup — the profile is not actually re-scanned.</x-mockup-note>
        </div>
    </div>
</x-layouts.app>
