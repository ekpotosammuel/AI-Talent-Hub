<x-layouts.app :title="$job['title']" side="candidate">
    <div class="flex flex-col gap-1.5">
        <a href="{{ route('candidate.jobs.index') }}" class="inline-flex w-fit items-center gap-1.5 text-sm text-ink-500 hover:text-ink-900">
            <x-icon name="arrow-right" class="size-3.5 rotate-180" />
            Back to match feed
        </a>
    </div>

    <div class="grid gap-5 lg:grid-cols-[1.4fr_1fr] lg:items-start">
        <div class="flex min-w-0 flex-col gap-5">
            {{-- Role header --}}
            <div class="card flex flex-col gap-5 p-6">
                <div class="flex flex-wrap items-start gap-4">
                    <span class="grid size-14 shrink-0 place-items-center rounded-xl bg-ink-900 text-base font-bold text-white">{{ $job['company_initials'] }}</span>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-2xl font-bold tracking-tight text-ink-900">{{ $job['title'] }}</h1>
                        <p class="mt-0.5 text-ink-500">{{ $job['company'] }} · {{ $job['location'] }}</p>
                        <div class="mt-3 flex flex-wrap gap-1.5">
                            <x-badge tone="neutral">{{ $job['arrangement'] }}</x-badge>
                            <x-badge tone="neutral">{{ $job['engagement']->label() }}</x-badge>
                            @if ($job['verified_employer'])
                                <x-badge tone="pass" icon="shield">Verified employer</x-badge>
                            @endif
                            <x-badge tone="neutral" class="num">{{ $job['id'] }}</x-badge>
                        </div>
                    </div>
                </div>

                <div class="rule grid gap-4 pt-5 sm:grid-cols-3">
                    @foreach ([
                        ['Salary', $job['salary']],
                        ['Posted', $job['posted']],
                        ['Applicants', $job['applicants'].' so far'],
                    ] as [$label, $value])
                        <div>
                            <p class="eyebrow">{{ $label }}</p>
                            <p class="num mt-1 font-semibold text-ink-900">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="flex flex-wrap gap-2">
                    <button type="button" class="btn btn-primary">Apply with reviewed CV</button>
                    <a href="{{ route('candidate.review.cover-letter') }}" class="btn btn-secondary">Tailor a cover letter</a>
                    <button type="button" class="btn btn-ghost">Save</button>
                </div>
            </div>

            {{-- Why it matched --}}
            <div class="card flex flex-col gap-5 p-6">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="font-semibold text-ink-900">Why this scored {{ $job['match'] }}</h2>
                        <p class="text-sm text-ink-500">Scored against your verified history, not keywords.</p>
                    </div>
                    <x-score :value="$job['match']" :size="72" />
                </div>

                <div class="flex flex-col gap-3">
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

                @if ($job['gaps'])
                    <div class="rule flex flex-col gap-2 pt-5">
                        <p class="eyebrow text-warn-700">What is working against you</p>
                        @foreach ($job['gaps'] as $gap)
                            <p class="flex items-start gap-2 text-sm text-ink-700">
                                <x-icon name="alert" class="mt-0.5 size-4 shrink-0 text-warn-500" />
                                {{ $gap }}
                            </p>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Side rail --}}
        <div class="flex min-w-0 flex-col gap-5">
            <div class="card flex flex-col gap-4 p-5">
                <p class="eyebrow">Before you apply</p>
                <div class="flex items-start gap-3 rounded-lg bg-warn-50 p-3">
                    <x-icon name="alert" class="mt-0.5 size-4 shrink-0 text-warn-700" />
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-ink-900">Your CV summary scores {{ $cv['sections'][0]['score'] }}</p>
                        <p class="mt-0.5 text-xs text-ink-600">{{ $cv['sections'][0]['note'] }}</p>
                        <a href="{{ route('candidate.review.cv') }}" class="link mt-1.5 inline-block text-xs">Fix it first</a>
                    </div>
                </div>

                <div class="flex items-start gap-3 rounded-lg bg-brand-50 p-3">
                    <x-icon name="shield" class="mt-0.5 size-4 shrink-0 text-brand-700" />
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-ink-900">This employer requires right to work</p>
                        <p class="mt-0.5 text-xs text-ink-600">Yours is still awaiting a passport page.</p>
                        <a href="{{ route('candidate.verification') }}" class="link mt-1.5 inline-block text-xs">Finish the check</a>
                    </div>
                </div>
            </div>

            <div class="card flex flex-col gap-3 p-5">
                <p class="eyebrow">Skills the role names</p>
                <div class="flex flex-wrap gap-1.5">
                    @foreach ($job['skills'] as $skill)
                        <x-badge :tone="in_array($skill, $candidate['skills'], true) ? 'pass' : 'neutral'" :icon="in_array($skill, $candidate['skills'], true) ? 'check' : null">
                            {{ $skill }}
                        </x-badge>
                    @endforeach
                </div>
                <p class="text-xs text-ink-500">Green means it is already evidenced on your verified profile.</p>
            </div>

            @if ($job['eor_available'])
                <div class="card-ink flex flex-col gap-2 p-5">
                    <x-icon name="globe" class="size-5 text-signal-400" />
                    <p class="font-semibold text-white">Hireable where you live</p>
                    <p class="text-sm text-ink-300">{{ $job['company'] }} has no entity in Nigeria, so this role would be employed through our employer of record.</p>
                    <a href="{{ route('eor') }}" class="link mt-1 text-sm text-signal-400 hover:text-signal-300">What that means for you</a>
                </div>
            @endif

            <x-mockup-note>Mockup — applying does not submit anything.</x-mockup-note>
        </div>
    </div>
</x-layouts.app>
