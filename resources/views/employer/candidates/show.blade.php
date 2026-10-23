<x-layouts.app :title="$candidate['name']" side="employer">
    <a href="{{ route('employer.pipeline') }}" class="inline-flex w-fit items-center gap-1.5 text-sm text-ink-500 hover:text-ink-900">
        <x-icon name="arrow-right" class="size-3.5 rotate-180" />
        Back to pipeline
    </a>

    {{-- Header --}}
    <div class="card flex flex-col gap-6 p-6">
        <div class="flex flex-wrap items-start gap-5">
            <x-avatar :initials="$candidate['initials']" size="size-16" />
            <div class="min-w-0 flex-1">
                <div class="flex flex-wrap items-center gap-2">
                    <h1 class="text-2xl font-bold tracking-tight text-ink-900">{{ $candidate['name'] }}</h1>
                    <x-badge tone="pass" icon="shield">{{ $record['cleared'] }}/{{ $record['total'] }} verified</x-badge>
                </div>
                <p class="mt-0.5 text-ink-500">{{ $candidate['headline'] }}</p>
                <p class="mt-1 text-sm text-ink-500">{{ $candidate['location'] }} · {{ $candidate['timezone'] }} · {{ $candidate['years_experience'] }} years</p>
            </div>

            <div class="flex shrink-0 items-center gap-5">
                <x-score :value="94" :size="84" label="Match" />
                <x-score :value="$interview['scorecard']['overall']" :size="84" label="AI interview" tone="brand" />
            </div>
        </div>

        <div class="rule flex flex-wrap gap-2 pt-5">
            <button type="button" class="btn btn-primary btn-sm">Move to team interview</button>
            <a href="{{ route('employer.interviews.show') }}" class="btn btn-secondary btn-sm">AI scorecard</a>
            <a href="{{ route('employer.verification.show') }}" class="btn btn-secondary btn-sm">Verification record</a>
            <button type="button" class="btn btn-ghost btn-sm">Reject with feedback</button>
        </div>
    </div>

    <div class="grid gap-5 lg:grid-cols-[1.4fr_1fr] lg:items-start">
        <div class="flex min-w-0 flex-col gap-5">
            {{-- Why they matched --}}
            <section class="card p-6">
                <h2 class="font-semibold text-ink-900">Why they matched {{ $job['title'] }}</h2>
                <div class="mt-4 flex flex-col gap-3">
                    @foreach ($job['why'] as $reason)
                        <div class="flex items-start gap-3 rounded-lg border border-ink-200 p-4">
                            <x-badge :tone="match ($reason['weight']) { 'Strong' => 'pass', 'Partial' => 'warn', default => 'neutral' }" class="shrink-0">{{ $reason['weight'] }}</x-badge>
                            <div class="min-w-0">
                                <p class="font-medium text-ink-900">{{ $reason['label'] }}</p>
                                <p class="mt-0.5 text-sm text-ink-600">{{ $reason['note'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- Verification summary --}}
            <section class="card overflow-hidden">
                <div class="flex items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
                    <h2 class="font-semibold text-ink-900">Verification</h2>
                    <a href="{{ route('employer.verification.show') }}" class="link text-sm">Full record</a>
                </div>
                <ul class="divide-y divide-ink-100">
                    @foreach ($record['checks'] as $check)
                        <li class="flex items-center gap-3.5 px-5 py-3.5">
                            <x-icon :name="$check['check']->icon()" class="size-4 shrink-0 text-ink-400" />
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-ink-900">{{ $check['check']->label() }}</p>
                                <p class="truncate text-xs text-ink-500">{{ $check['evidence'] }}</p>
                            </div>
                            <x-status-badge :status="$check['status']" class="shrink-0" />
                        </li>
                    @endforeach
                </ul>
            </section>

            {{-- Documents --}}
            <section class="card p-6">
                <h2 class="font-semibold text-ink-900">Documents</h2>
                <p class="mt-1 text-sm text-ink-500">The candidate shared the reviewed versions. Scores are theirs, not ours.</p>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    @foreach ([
                        ['CV', $cv['file'], $cv['overall'], 'document'],
                        ['Cover letter', 'northwind-pay-cover-letter.docx', 64, 'mail'],
                    ] as [$label, $file, $score, $icon])
                        <div class="flex items-center gap-3 rounded-lg border border-ink-200 p-4">
                            <x-icon :name="$icon" class="size-5 shrink-0 text-ink-400" />
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-ink-900">{{ $label }}</p>
                                <p class="num truncate text-xs text-ink-500">{{ $file }}</p>
                            </div>
                            <button type="button" class="btn btn-ghost btn-sm shrink-0">
                                <x-icon name="download" class="size-3.5" />
                            </button>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <div class="flex min-w-0 flex-col gap-5">
            <div class="card flex flex-col gap-3 p-5">
                <p class="eyebrow">Skills</p>
                <div class="flex flex-wrap gap-1.5">
                    @foreach ($candidate['skills'] as $skill)
                        <x-badge :tone="$loop->index < 5 ? 'pass' : 'neutral'" :icon="$loop->index < 5 ? 'check' : null">{{ $skill }}</x-badge>
                    @endforeach
                </div>
                <p class="text-xs text-ink-500">Green skills are backed by a verified employment check.</p>
            </div>

            <div class="card flex flex-col gap-3 p-5">
                <p class="eyebrow">Employment</p>
                <p class="text-sm text-ink-700">Lives in <span class="font-semibold">{{ $record['country'] }}</span>; you are hiring into <span class="font-semibold">{{ $record['hiring_country'] }}</span>.</p>
                <div class="flex items-start gap-2.5 rounded-lg bg-brand-50 p-3">
                    <x-icon name="globe" class="mt-0.5 size-4 shrink-0 text-brand-700" />
                    <p class="text-xs leading-relaxed text-ink-700">
                        You have no entity in Nigeria. Hire through employer of record — onboarding takes 5 days at +15% employer cost.
                    </p>
                </div>
                <a href="{{ route('employer.eor.onboard') }}" class="btn btn-secondary btn-sm">Start EOR onboarding</a>
            </div>

            <div class="card flex flex-col gap-3 p-5">
                <p class="eyebrow">Open to</p>
                @foreach ($candidate['open_to'] as $option)
                    <p class="flex items-center gap-2 text-sm text-ink-700">
                        <x-icon name="check" class="size-4 shrink-0 text-signal-600" />
                        {{ $option }}
                    </p>
                @endforeach
            </div>

            <x-mockup-note>Mockup — stage changes and downloads do nothing.</x-mockup-note>
        </div>
    </div>
</x-layouts.app>
