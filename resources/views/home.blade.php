<x-layouts.marketing>
    {{-- ───────────────────────── Hero: one real match, shown whole ───────────────────────── --}}
    <section class="relative overflow-hidden border-b border-ink-200 bg-white">
        <div class="paper-grid pointer-events-none absolute inset-0 opacity-[0.35]"></div>
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-brand-300 to-transparent"></div>

        <div class="relative mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-[1.05fr_1fr] lg:items-center lg:gap-16 lg:px-8 lg:py-24">
            <div class="flex min-w-0 flex-col gap-7">
                <div class="flex flex-wrap items-center gap-2">
                    <x-badge tone="ink" icon="shield">7 checks before a shortlist</x-badge>
                    <x-badge tone="neutral">Employer of record in {{ \App\Support\MockData::eorCountryCount() }}+ countries</x-badge>
                </div>

                <h1 class="font-display text-[2.6rem] leading-[1.03] font-bold tracking-[-0.03em] text-ink-900 sm:text-6xl">
                    Two sides of<br>the same hire.
                </h1>

                <p class="max-w-xl text-lg leading-relaxed text-ink-600">
                    Candidates arrive ready — CV rewritten, interview drilled, credentials verified.
                    Employers get a shortlist they can prove, interviewed in the first round and
                    employable in {{ \App\Support\MockData::eorCountryCount() }} countries without opening an entity.
                </p>

                <div class="flex flex-col gap-3 sm:flex-row">
                    @foreach ($sides as $accountSide)
                        <a href="{{ route('register', ['account' => $accountSide->value]) }}"
                           @class([
                               'btn btn-lg flex-1',
                               'btn-ink' => $loop->first,
                               'btn-secondary' => ! $loop->first,
                           ])>
                            {{ $loop->first ? 'I’m job hunting' : 'I’m hiring' }}
                            <x-icon name="arrow-right" class="size-4" />
                        </a>
                    @endforeach
                </div>

                <div class="rule flex flex-col gap-3 pt-6">
                    <p class="eyebrow">Roles ingested from</p>
                    <div class="flex flex-wrap items-center gap-x-5 gap-y-2">
                        @foreach ($feeds as $feed)
                            <span class="font-mono text-sm font-medium tracking-tight text-ink-500">{{ $feed }}</span>
                        @endforeach
                        <span class="num text-sm text-ink-400">· synced every {{ (int) config('talent.job_feeds.sync_minutes') }} min</span>
                    </div>
                </div>
            </div>

            {{-- The match record: the one artifact that only this product produces. --}}
            <div class="relative min-w-0">
                <div class="card-ink ink-grid relative overflow-hidden p-6 sm:p-7">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="eyebrow text-signal-400">Match record</p>
                            <p class="num mt-1 text-xs text-ink-400">{{ $verification['reference'] }} · {{ $featuredJob['id'] }}</p>
                        </div>
                        <x-score :value="$featuredJob['match']" :size="92" tone="signal" />
                    </div>

                    <div class="mt-6 flex items-center gap-3 rounded-xl bg-white/5 p-3 ring-1 ring-inset ring-white/10">
                        <x-avatar :initials="$verification['initials']" tone="signal" size="size-11" />
                        <div class="min-w-0 flex-1">
                            <p class="truncate font-semibold text-white">{{ $verification['candidate'] }}</p>
                            <p class="truncate text-xs text-ink-400">Senior Backend Engineer · Payments · Lagos</p>
                        </div>
                        <x-badge tone="glass" icon="check" class="shrink-0">{{ $verification['cleared'] }}/{{ $verification['total'] }}</x-badge>
                    </div>

                    <div class="mt-3 flex items-center gap-3 rounded-xl bg-white/5 p-3 ring-1 ring-inset ring-white/10">
                        <span class="grid size-11 shrink-0 place-items-center rounded-full bg-white text-xs font-bold text-ink-900">{{ $featuredJob['company_initials'] }}</span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate font-semibold text-white">{{ $featuredJob['title'] }}</p>
                            <p class="truncate text-xs text-ink-400">{{ $featuredJob['company'] }} · {{ $featuredJob['location'] }}</p>
                        </div>
                        <x-badge tone="glass" class="shrink-0">{{ $featuredJob['source'] }}</x-badge>
                    </div>

                    <div class="mt-6 flex flex-col gap-3">
                        <p class="eyebrow text-ink-400">Why it scored {{ $featuredJob['match'] }}</p>
                        @foreach ($featuredJob['why'] as $reason)
                            <div class="flex items-start gap-3">
                                <span @class([
                                    'mt-1.5 grid size-4 shrink-0 place-items-center rounded-full text-[0.625rem] font-bold',
                                    'bg-signal-400 text-ink-900' => $reason['weight'] === 'Strong',
                                    'bg-warn-500 text-ink-900' => $reason['weight'] === 'Partial',
                                    'bg-ink-600 text-ink-300' => $reason['weight'] === 'Missing',
                                ])>
                                    {{ $reason['weight'] === 'Strong' ? '✓' : ($reason['weight'] === 'Partial' ? '~' : '·') }}
                                </span>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-white">{{ $reason['label'] }}</p>
                                    <p class="text-xs leading-relaxed text-ink-400">{{ $reason['note'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex flex-wrap items-center justify-between gap-3 border-t border-white/10 pt-5">
                        <p class="text-xs text-ink-400">
                            Hireable in <span class="font-semibold text-white">Nigeria</span> via employer of record.
                            No entity needed.
                        </p>
                        <a href="{{ route('candidate.jobs.show', ['job' => $featuredJob['id']]) }}" class="btn btn-signal btn-sm">
                            Open the breakdown
                        </a>
                    </div>
                </div>

                <p class="mt-3 text-center text-xs text-ink-400">A mockup record. Every screen below uses this same candidate and role.</p>
            </div>
        </div>
    </section>

    {{-- ───────────────────────── The two sides ───────────────────────── --}}
    <section class="border-b border-ink-200 bg-ink-50">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="flex flex-col gap-3">
                <p class="eyebrow">What each side gets</p>
                <h2 class="max-w-2xl text-3xl font-bold tracking-tight text-ink-900 sm:text-4xl">
                    One platform, two jobs to do.
                </h2>
            </div>

            <div class="mt-10 grid gap-5 lg:grid-cols-2">
                {{-- Candidate --}}
                <div class="card flex flex-col gap-6 p-7">
                    <div class="flex items-center gap-3">
                        <span class="grid size-10 place-items-center rounded-xl bg-brand-600 text-white">
                            <x-icon name="sparkles" class="size-5" />
                        </span>
                        <div>
                            <p class="eyebrow">Candidate side</p>
                            <h3 class="text-xl font-bold tracking-tight">Get ready, then get matched</h3>
                        </div>
                    </div>

                    <ul class="flex flex-col gap-4">
                        @foreach ([
                            ['sparkles', 'Job matching', 'Roles from five ATS feeds, scored against your real history — with the reasons and the gaps written out.', 'candidate.jobs.index'],
                            ['document', 'CV, cover letter and LinkedIn review', 'Section scores, the exact line that is failing, and the rewrite beside it.', 'candidate.review.cv'],
                            ['mic', 'Interview preparation', 'Four tracks, voice drills, and live signals on structure, pace and filler words.', 'candidate.interview-prep.index'],
                            ['chart', 'Post-interview feedback', 'A scorecard against the employer’s own bar, with three things to do next.', 'candidate.feedback'],
                        ] as [$icon, $name, $copy, $route])
                            <li class="flex gap-3.5">
                                <span class="mt-0.5 grid size-8 shrink-0 place-items-center rounded-lg bg-brand-50 text-brand-600">
                                    <x-icon :name="$icon" class="size-4" />
                                </span>
                                <div class="min-w-0">
                                    <a href="{{ route($route) }}" class="font-semibold text-ink-900 hover:text-brand-700">{{ $name }}</a>
                                    <p class="mt-0.5 text-sm leading-relaxed text-ink-500">{{ $copy }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-auto flex flex-wrap items-center gap-3 border-t border-ink-200 pt-5">
                        <a href="{{ route('candidates') }}" class="btn btn-primary btn-sm">See the candidate product</a>
                        <span class="text-xs font-semibold text-ink-500">Free, always</span>
                    </div>
                </div>

                {{-- Employer --}}
                <div class="card flex flex-col gap-6 p-7">
                    <div class="flex items-center gap-3">
                        <span class="grid size-10 place-items-center rounded-xl bg-ink-900 text-signal-400">
                            <x-icon name="building" class="size-5" />
                        </span>
                        <div>
                            <p class="eyebrow">Employer side</p>
                            <h3 class="text-xl font-bold tracking-tight">Hire proven people, compliantly</h3>
                        </div>
                    </div>

                    <ul class="flex flex-col gap-4">
                        @foreach ([
                            ['shield', 'Candidate verification', 'Seven checks against named data sources. Identity, right to work, employment, education, certifications, references, sanctions.', 'verification'],
                            ['mic', 'AI interview stage', 'An automated, structured first round. Weighted competencies, timestamped evidence, human review before any decision.', 'employer.interviews.index'],
                            ['globe', 'Employer of record', 'We become the legal employer in '.\App\Support\MockData::eorCountryCount().' countries. Contracts, payroll, tax and statutory benefits.', 'eor'],
                            ['chart', 'Ongoing talent management', 'Probation close-outs, reviews, renewal dates and retention risk after the hire lands.', 'employer.talent'],
                        ] as [$icon, $name, $copy, $route])
                            <li class="flex gap-3.5">
                                <span class="mt-0.5 grid size-8 shrink-0 place-items-center rounded-lg bg-ink-100 text-ink-700">
                                    <x-icon :name="$icon" class="size-4" />
                                </span>
                                <div class="min-w-0">
                                    <a href="{{ route($route) }}" class="font-semibold text-ink-900 hover:text-brand-700">{{ $name }}</a>
                                    <p class="mt-0.5 text-sm leading-relaxed text-ink-500">{{ $copy }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-auto flex flex-wrap items-center gap-3 border-t border-ink-200 pt-5">
                        <a href="{{ route('employers') }}" class="btn btn-ink btn-sm">See the employer product</a>
                        <span class="num text-xs font-semibold text-ink-500">From ${{ 690 }}/role/month</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ───────────────────────── The pipeline (a real sequence, so numbered) ───────────────────────── --}}
    <section class="border-b border-ink-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="flex flex-col gap-3">
                <p class="eyebrow">How a match is made</p>
                <h2 class="max-w-2xl text-3xl font-bold tracking-tight sm:text-4xl">Four steps, in this order, every time.</h2>
            </div>

            <ol class="mt-10 grid gap-px overflow-hidden rounded-2xl border border-ink-200 bg-ink-200 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['Ingest', 'Roles land from Greenhouse, Lever, Ashby, Workable and LinkedIn every '.(int) config('talent.job_feeds.sync_minutes').' minutes, de-duplicated by employer and title.'],
                    ['Verify', 'The candidate’s identity, history and credentials are checked once against the source, then reused for every application.'],
                    ['Score', 'Each role is scored against verified history — not keywords. Anything under '.(int) config('talent.match_threshold').' never reaches either side.'],
                    ['Explain', 'Both sides see the same breakdown: what matched, what is partial, what is missing, and what to do about it.'],
                ] as [$step, $copy])
                    <li class="flex flex-col gap-3 bg-white p-6">
                        <span class="num font-display text-3xl font-bold text-ink-200">0{{ $loop->iteration }}</span>
                        <p class="font-display text-lg font-bold tracking-tight">{{ $step }}</p>
                        <p class="text-sm leading-relaxed text-ink-500">{{ $copy }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- ───────────────────────── Document review, shown not described ───────────────────────── --}}
    @php($issue = \App\Support\MockData::cvReview()['issues'][0])
    <section class="border-b border-ink-200 bg-ink-50">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:items-center lg:px-8 lg:py-20">
            <div class="flex min-w-0 flex-col gap-5">
                <p class="eyebrow">Candidate side · document review</p>
                <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">We don’t grade your CV. We rewrite the line.</h2>
                <p class="text-lg leading-relaxed text-ink-600">
                    Every issue comes with the sentence that caused it, the replacement, and why a
                    recruiter or an ATS parser would have stopped there. Same treatment for cover
                    letters and LinkedIn profiles.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('candidate.review.cv') }}" class="btn btn-primary">Open a CV review</a>
                    <a href="{{ route('candidates') }}" class="btn btn-secondary">All four reviews</a>
                </div>
            </div>

            <figure class="card min-w-0 overflow-hidden">
                <figcaption class="flex items-center justify-between gap-3 border-b border-ink-200 bg-white px-5 py-3.5">
                    <div class="flex items-center gap-2.5">
                        <x-icon name="document" class="size-4 text-ink-400" />
                        <span class="num text-sm font-medium text-ink-700">amara-okonkwo-cv.pdf</span>
                    </div>
                    <x-badge tone="stop">High · page 1</x-badge>
                </figcaption>

                <div class="flex flex-col gap-4 p-5">
                    <p class="font-semibold text-ink-900">{{ $issue['title'] }}</p>

                    <div class="flex flex-col gap-1.5">
                        <p class="eyebrow">On the page now</p>
                        <blockquote class="rounded-lg border-l-2 border-stop-500 bg-stop-50/60 px-4 py-3 text-sm leading-relaxed text-ink-700 italic">
                            “{{ $issue['quote'] }}”
                        </blockquote>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <p class="eyebrow text-signal-700">Replace it with</p>
                        <blockquote class="rounded-lg border-l-2 border-signal-500 bg-signal-200/30 px-4 py-3 text-sm leading-relaxed text-ink-900">
                            {{ $issue['fix'] }}
                        </blockquote>
                    </div>

                    <p class="flex items-start gap-2 text-xs leading-relaxed text-ink-500">
                        <x-icon name="alert" class="mt-px size-3.5 shrink-0" />
                        {{ $issue['why'] }}
                    </p>
                </div>
            </figure>
        </div>
    </section>

    {{-- ───────────────────────── Verification ───────────────────────── --}}
    <section class="border-b border-white/10 bg-ink-950">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="flex flex-col gap-10 lg:flex-row lg:items-end lg:justify-between">
                <div class="flex max-w-2xl flex-col gap-4">
                    <p class="eyebrow text-signal-400">Employer side · verification</p>
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        Seven checks, and the source for each one.
                    </h2>
                    <p class="text-lg leading-relaxed text-ink-300">
                        A candidate consents once. The record is theirs, reusable across every
                        application, and an employer sees the evidence — not a green tick they have
                        to take on trust.
                    </p>
                </div>
                <a href="{{ route('verification') }}" class="btn btn-signal shrink-0">How verification works</a>
            </div>

            <div class="mt-12 grid gap-px overflow-hidden rounded-2xl bg-white/10 sm:grid-cols-2 lg:grid-cols-4">
                @foreach (\App\Enums\VerificationCheck::cases() as $check)
                    <div class="flex flex-col gap-2.5 bg-ink-950 p-5">
                        <span class="grid size-9 place-items-center rounded-lg bg-white/5 text-signal-400 ring-1 ring-inset ring-white/10">
                            <x-icon :name="$check->icon()" class="size-4" />
                        </span>
                        <p class="font-semibold text-white">{{ $check->label() }}</p>
                        <p class="text-xs leading-relaxed text-ink-400">{{ $check->description() }}</p>
                        <p class="num mt-auto pt-2 text-xs text-signal-400">{{ $check->provider() }}</p>
                    </div>
                @endforeach

                <div class="flex flex-col justify-center gap-2 bg-signal-400 p-5 text-ink-900">
                    <p class="num font-display text-4xl font-bold">94.2%</p>
                    <p class="text-sm font-semibold">cleared on the first attempt</p>
                    <p class="text-xs text-ink-800">Across 112,604 checks run on the platform.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ───────────────────────── AI interview + guardrails ───────────────────────── --}}
    @php($interview = \App\Support\MockData::aiInterview())
    <section class="border-b border-ink-200 bg-white">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-[1.1fr_0.9fr] lg:items-start lg:px-8 lg:py-20">
            <figure class="card min-w-0 overflow-hidden">
                <figcaption class="flex items-center justify-between gap-3 border-b border-ink-200 px-5 py-3.5">
                    <div class="flex items-center gap-2.5">
                        <x-avatar :initials="$interview['scorecard']['initials']" size="size-8" />
                        <div>
                            <p class="text-sm font-semibold text-ink-900">{{ $interview['scorecard']['candidate'] }}</p>
                            <p class="num text-xs text-ink-500">Completed in {{ $interview['scorecard']['completed_in'] }}</p>
                        </div>
                    </div>
                    <x-score :value="$interview['scorecard']['overall']" :size="64" label="" />
                </figcaption>

                <div class="flex flex-col gap-4 p-5">
                    @foreach ($interview['scorecard']['dimensions'] as $dimension)
                        <x-meter :value="$dimension['score']" :label="$dimension['name']" :note="$dimension['note']" />
                    @endforeach

                    <div class="rule flex flex-col gap-2 pt-4">
                        <p class="eyebrow">Evidence</p>
                        @foreach ($interview['scorecard']['highlights'] as $highlight)
                            <p class="flex gap-3 text-xs leading-relaxed text-ink-600">
                                <span class="num shrink-0 font-semibold text-brand-700">{{ $highlight['at'] }}</span>
                                {{ $highlight['text'] }}
                            </p>
                        @endforeach
                    </div>
                </div>
            </figure>

            <div class="flex min-w-0 flex-col gap-5">
                <p class="eyebrow">Employer side · automated interviews</p>
                <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">A structured first round, run at any hour.</h2>
                <p class="text-lg leading-relaxed text-ink-600">
                    Every candidate gets the same questions, weighted against competencies you set.
                    Scores come back with the timestamp that earned them, so a human can check the
                    work before anyone is moved or passed over.
                </p>

                <ul class="flex flex-col gap-2.5">
                    @foreach ($interview['guardrails'] as $guardrail)
                        <li class="flex gap-2.5 text-sm leading-relaxed text-ink-700">
                            <x-icon name="check" class="mt-0.5 size-4 shrink-0 text-signal-600" />
                            {{ $guardrail }}
                        </li>
                    @endforeach
                </ul>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('employer.interviews.create') }}" class="btn btn-ink">Configure a round</a>
                    <a href="{{ route('employer.interviews.show') }}" class="btn btn-secondary">See a full scorecard</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ───────────────────────── Employer of record ───────────────────────── --}}
    <section class="border-b border-ink-200 bg-ink-50">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="flex flex-col gap-10 lg:flex-row lg:items-end lg:justify-between">
                <div class="flex max-w-2xl flex-col gap-4">
                    <p class="eyebrow">Employer side · employer of record</p>
                    <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Hire in {{ \App\Support\MockData::eorCountryCount() }} countries without an entity.</h2>
                    <p class="text-lg leading-relaxed text-ink-600">
                        We sign the employment contract under local law, run payroll, withhold tax
                        and administer statutory benefits. You manage the work.
                    </p>
                </div>
                <a href="{{ route('eor') }}" class="btn btn-primary shrink-0">Country coverage</a>
            </div>

            <div class="card mt-10 overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Country</th>
                            <th>Entity</th>
                            <th>Onboarding</th>
                            <th>Employer cost uplift</th>
                            <th>Statutory notice</th>
                            <th class="hidden md:table-cell">Annual leave</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (array_slice($countries, 0, 6) as $country)
                            <tr>
                                <td class="font-medium text-ink-900">
                                    <span class="mr-2" aria-hidden="true">{{ $country['flag'] }}</span>{{ $country['country'] }}
                                </td>
                                <td>
                                    <x-badge :tone="$country['entity'] === 'Own entity' ? 'pass' : 'neutral'">{{ $country['entity'] }}</x-badge>
                                </td>
                                <td class="num">{{ $country['onboarding'] }}</td>
                                <td class="num">{{ $country['cost_uplift'] }}</td>
                                <td class="num">{{ $country['notice'] }}</td>
                                <td class="num hidden md:table-cell">{{ $country['leave'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- ───────────────────────── Pricing + close ───────────────────────── --}}
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="flex flex-col gap-3 text-center">
                <p class="eyebrow mx-auto">Pricing</p>
                <h2 class="mx-auto max-w-2xl text-3xl font-bold tracking-tight sm:text-4xl">Candidates never pay. Employers pay per role.</h2>
            </div>

            <div class="mt-10 grid items-start gap-5 lg:grid-cols-3">
                @foreach ($plans as $plan)
                    <div @class([
                        'flex flex-col gap-5 p-7',
                        'card-ink lg:-mt-4 lg:pb-9' => $plan['featured'],
                        'card' => ! $plan['featured'],
                    ])>
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p @class(['eyebrow', 'text-signal-400' => $plan['featured']])>{{ $plan['name'] }}</p>
                                <p @class(['num mt-2 font-display text-4xl font-bold tracking-tight', 'text-white' => $plan['featured']])>{{ $plan['price'] }}</p>
                                <p @class(['text-xs', 'text-ink-400' => $plan['featured'], 'text-ink-500' => ! $plan['featured']])>{{ $plan['cadence'] }}</p>
                            </div>
                            @if ($plan['featured'])
                                <x-badge tone="signal">Most used</x-badge>
                            @endif
                        </div>

                        <p @class(['text-sm leading-relaxed', 'text-ink-300' => $plan['featured'], 'text-ink-600' => ! $plan['featured']])>{{ $plan['pitch'] }}</p>

                        <ul class="flex flex-col gap-2.5">
                            @foreach ($plan['features'] as $feature)
                                <li @class(['flex gap-2.5 text-sm', 'text-ink-200' => $plan['featured'], 'text-ink-700' => ! $plan['featured']])>
                                    <x-icon name="check" @class(['mt-0.5 size-4 shrink-0', 'text-signal-400' => $plan['featured'], 'text-signal-600' => ! $plan['featured']]) />
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>

                        <a href="{{ route($plan['route'], $plan['params']) }}" @class([
                            'btn mt-auto w-full',
                            'btn-signal' => $plan['featured'],
                            'btn-secondary' => ! $plan['featured'],
                        ])>{{ $plan['cta'] }}</a>
                    </div>
                @endforeach
            </div>

            <div class="mt-14 flex flex-col items-center gap-4 rounded-2xl border border-ink-200 bg-ink-50 px-6 py-10 text-center">
                <h2 class="max-w-xl text-2xl font-bold tracking-tight sm:text-3xl">Every screen in this build is clickable.</h2>
                <p class="max-w-xl text-sm text-ink-600">
                    This is an interface mockup — no live data, no integrations. The screen index walks
                    all {{ 35 }}+ mockups across the public site, both apps, the admin console and mobile.
                </p>
                <div class="flex flex-wrap justify-center gap-3">
                    <a href="{{ route('mockups') }}" class="btn btn-ink">Browse all screens</a>
                    <a href="{{ route('mobile') }}" class="btn btn-secondary">
                        <x-icon name="phone" class="size-4" />
                        Mobile apps
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.marketing>
