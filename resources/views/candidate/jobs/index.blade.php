<x-layouts.app title="Match feed" side="candidate">
    <x-page-header
        title="Match feed"
        description="Roles from {{ count($feeds) }} connected feeds, scored against your verified history. Anything under {{ $threshold }} is hidden."
        eyebrow="Global job feeds"
    >
        <x-slot:actions>
            <button type="button" class="btn btn-secondary btn-sm">
                <x-icon name="filter" class="size-4" />
                Filters
            </button>
            <button type="button" class="btn btn-ghost btn-sm">Save this search</button>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-5 lg:grid-cols-[16rem_1fr]">
        {{-- Filters --}}
        <aside class="flex flex-col gap-5">
            <div class="card flex flex-col gap-4 p-5">
                <div class="flex flex-col gap-2">
                    <p class="eyebrow">Minimum match</p>
                    <input type="range" min="50" max="100" value="{{ $threshold }}" class="w-full accent-brand-600" aria-label="Minimum match score">
                    <p class="num text-xs text-ink-500">{{ $threshold }} and above</p>
                </div>

                <div class="rule flex flex-col gap-2 pt-4">
                    <p class="eyebrow">Arrangement</p>
                    @foreach (['Remote', 'Hybrid', 'On-site'] as $arrangement)
                        <label class="flex items-center gap-2 text-sm text-ink-700">
                            <input type="checkbox" class="checkbox" @checked($arrangement !== 'On-site')>
                            {{ $arrangement }}
                        </label>
                    @endforeach
                </div>

                <div class="rule flex flex-col gap-2 pt-4">
                    <p class="eyebrow">Engagement</p>
                    @foreach (\App\Enums\EngagementType::cases() as $engagement)
                        <label class="flex items-center gap-2 text-sm text-ink-700">
                            <input type="checkbox" class="checkbox" checked>
                            {{ $engagement->label() }}
                        </label>
                    @endforeach
                </div>

                <div class="rule flex flex-col gap-2 pt-4">
                    <p class="eyebrow">Source feed</p>
                    @foreach ($feeds as $feed)
                        <label class="flex items-center gap-2 text-sm text-ink-700">
                            <input type="checkbox" class="checkbox" checked>
                            <span class="num">{{ $feed }}</span>
                        </label>
                    @endforeach
                </div>

                <label class="rule flex items-center gap-2 pt-4 text-sm font-medium text-ink-900">
                    <input type="checkbox" class="checkbox" checked>
                    Verified employers only
                </label>
            </div>

            <div class="card-ink flex flex-col gap-2 p-5">
                <p class="eyebrow text-signal-400">Your profile</p>
                <p class="text-sm text-ink-300">{{ $candidate['target_role'] }}</p>
                <p class="num text-sm text-white">{{ $candidate['target_salary'] }}</p>
                <a href="{{ route('candidate.profile') }}" class="btn btn-signal btn-sm mt-2">Tune matching</a>
            </div>
        </aside>

        {{-- Results --}}
        <div class="flex min-w-0 flex-col gap-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <p class="text-sm text-ink-600"><span class="num font-semibold text-ink-900">{{ $jobs->count() }}</span> roles match you today</p>
                <label class="flex items-center gap-2 text-sm text-ink-600">
                    Sort
                    <select class="input w-auto py-1.5 text-sm">
                        <option>Best match</option>
                        <option>Newest</option>
                        <option>Salary</option>
                        <option>Fewest applicants</option>
                    </select>
                </label>
            </div>

            @foreach ($jobs as $job)
                <article class="card flex flex-col gap-4 p-5 transition hover:border-brand-300 sm:flex-row sm:items-start">
                    <span class="grid size-12 shrink-0 place-items-center rounded-xl bg-ink-900 text-sm font-bold text-white">{{ $job['company_initials'] }}</span>

                    <div class="flex min-w-0 flex-1 flex-col gap-2.5">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div class="min-w-0">
                                <a href="{{ route('candidate.jobs.show', ['job' => $job['id']]) }}" class="font-semibold text-ink-900 hover:text-brand-700">{{ $job['title'] }}</a>
                                <p class="text-sm text-ink-500">{{ $job['company'] }} · {{ $job['location'] }}</p>
                            </div>
                            <x-score :value="$job['match']" :size="56" class="shrink-0" />
                        </div>

                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-ink-600">
                            <span class="num font-medium text-ink-900">{{ $job['salary'] }}</span>
                            <span>{{ $job['engagement']->label() }}</span>
                            <span class="num text-ink-500">{{ $job['posted'] }} · {{ $job['applicants'] }} applicants</span>
                        </div>

                        <div class="flex flex-wrap gap-1.5">
                            @foreach ($job['skills'] as $skill)
                                <x-badge tone="neutral">{{ $skill }}</x-badge>
                            @endforeach
                            @if ($job['verified_employer'])
                                <x-badge tone="pass" icon="shield">Verified employer</x-badge>
                            @else
                                <x-badge tone="warn" icon="alert">Employer unverified</x-badge>
                            @endif
                            @if ($job['eor_available'])
                                <x-badge tone="brand" icon="globe">Hireable via EOR</x-badge>
                            @endif
                        </div>

                        @if ($job['gaps'])
                            <p class="flex items-start gap-2 text-xs leading-relaxed text-warn-700">
                                <x-icon name="alert" class="mt-px size-3.5 shrink-0" />
                                {{ implode(' · ', $job['gaps']) }}
                            </p>
                        @endif

                        <div class="mt-1 flex flex-wrap gap-2">
                            <a href="{{ route('candidate.jobs.show', ['job' => $job['id']]) }}" class="btn btn-primary btn-sm">Why {{ $job['match'] }}?</a>
                            <button type="button" class="btn btn-secondary btn-sm">Apply with reviewed CV</button>
                            <button type="button" class="btn btn-ghost btn-sm">Not interested</button>
                        </div>
                    </div>
                </article>
            @endforeach

            <x-mockup-note>Mockup — filters and sorting are not wired to anything.</x-mockup-note>
        </div>
    </div>
</x-layouts.app>
