<x-layouts.marketing title="For employers">
    <section class="border-b border-ink-200 bg-white">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-[1.05fr_0.95fr] lg:items-center lg:px-8 lg:py-20">
            <div class="flex min-w-0 flex-col gap-6">
                <x-badge tone="ink" icon="shield" class="w-fit">Verified before shortlist</x-badge>
                <h1 class="font-display text-4xl leading-[1.05] font-bold tracking-tight sm:text-5xl">
                    Hire people you can prove.
                </h1>
                <p class="max-w-xl text-lg leading-relaxed text-ink-600">
                    Seven checks against named data sources, a structured first-round interview run
                    automatically, and employment infrastructure in {{ \App\Support\MockData::eorCountryCount() }} countries — so where
                    they live stops being the problem.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('register', ['account' => 'employer']) }}" class="btn btn-ink btn-lg">Start hiring</a>
                    <a href="{{ route('employer.dashboard') }}" class="btn btn-secondary btn-lg">Open the mockup</a>
                </div>
            </div>

            <div class="card min-w-0 overflow-hidden">
                <div class="flex items-center justify-between gap-3 border-b border-ink-200 px-5 py-3.5">
                    <p class="eyebrow">Open roles</p>
                    <x-badge tone="neutral">{{ $roles->count() }} live</x-badge>
                </div>
                <div class="divide-y divide-ink-100">
                    @foreach ($roles->take(3) as $role)
                        <div class="flex items-center gap-4 px-5 py-4">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-semibold text-ink-900">{{ $role['title'] }}</p>
                                <p class="truncate text-xs text-ink-500">{{ $role['location'] }} · {{ $role['engagement']->label() }}</p>
                            </div>
                            <div class="shrink-0 text-right">
                                <p class="num text-sm font-bold text-ink-900">{{ $role['verified_share'] }}%</p>
                                <p class="text-xs text-ink-500">verified</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex items-center justify-between gap-3 bg-ink-50 px-5 py-3.5">
                    <p class="text-xs text-ink-500">Median time to offer</p>
                    <p class="num text-sm font-bold text-ink-900">19 days</p>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-ink-200 bg-ink-50">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">The seven checks</h2>
            <p class="mt-3 max-w-2xl text-lg text-ink-600">Run once, with the candidate’s consent. Reusable across every employer on the platform.</p>

            <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($checks as $check)
                    <div class="card flex flex-col gap-2.5 p-5">
                        <span class="grid size-9 place-items-center rounded-lg bg-ink-900 text-signal-400">
                            <x-icon :name="$check->icon()" class="size-4" />
                        </span>
                        <p class="font-semibold text-ink-900">{{ $check->label() }}</p>
                        <p class="text-xs leading-relaxed text-ink-500">{{ $check->description() }}</p>
                        <p class="num mt-auto pt-1 text-xs font-semibold text-brand-700">{{ $check->provider() }}</p>
                    </div>
                @endforeach
                <a href="{{ route('verification') }}" class="card flex flex-col justify-center gap-2 bg-ink-900 p-5 text-white transition hover:bg-ink-800">
                    <p class="font-semibold">How verification works</p>
                    <span class="inline-flex items-center gap-1.5 text-sm text-signal-400">
                        Read more
                        <x-icon name="arrow-right" class="size-3.5" />
                    </span>
                </a>
            </div>
        </div>
    </section>

    <section class="border-b border-ink-200 bg-white">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:items-center lg:px-8 lg:py-20">
            <div class="flex min-w-0 flex-col gap-5">
                <p class="eyebrow">Automated interviews</p>
                <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">The first round, without the scheduling.</h2>
                <p class="text-lg leading-relaxed text-ink-600">
                    {{ $interview['invited'] }} invited, {{ $interview['completed'] }} completed, median score {{ $interview['median_score'] }}.
                    Every answer kept as audio, transcript and score, with the timestamp that earned it.
                </p>
                <ul class="flex flex-col gap-2.5">
                    @foreach ($interview['guardrails'] as $guardrail)
                        <li class="flex gap-2.5 text-sm leading-relaxed text-ink-700">
                            <x-icon name="check" class="mt-0.5 size-4 shrink-0 text-signal-600" />
                            {{ $guardrail }}
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('employer.interviews.index') }}" class="btn btn-primary w-fit">See the interview product</a>
            </div>

            <div class="card min-w-0 p-6">
                <p class="eyebrow">Competency weights</p>
                <div class="mt-4 flex flex-col gap-4">
                    @foreach ($interview['competencies'] as $competency)
                        <x-meter :value="$competency['weight']" :max="40" :label="$competency['name']" tone="ink" />
                    @endforeach
                </div>
                <div class="rule mt-5 flex flex-col gap-2 pt-5">
                    <p class="eyebrow">Questions asked</p>
                    @foreach (array_slice($interview['questions'], 0, 3) as $question)
                        <p class="flex gap-2.5 text-sm leading-relaxed text-ink-600">
                            <span class="num shrink-0 font-semibold text-ink-400">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            {{ $question }}
                        </p>
                    @endforeach
                    <p class="num text-xs text-ink-400">+ {{ count($interview['questions']) - 3 }} more</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-ink-50">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="flex flex-col gap-10 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <p class="eyebrow">Employer of record</p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">Then we employ them for you.</h2>
                    <p class="mt-3 text-lg text-ink-600">Local contracts, payroll, tax and statutory benefits in {{ \App\Support\MockData::eorCountryCount() }} countries. You manage the work; we carry the employment.</p>
                </div>
                <a href="{{ route('eor') }}" class="btn btn-ink shrink-0">How EOR works</a>
            </div>

            <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach (array_slice($countries, 0, 4) as $country)
                    <div class="card flex flex-col gap-1.5 p-5">
                        <span class="text-2xl" aria-hidden="true">{{ $country['flag'] }}</span>
                        <p class="font-semibold text-ink-900">{{ $country['country'] }}</p>
                        <p class="num text-sm text-ink-600">Onboard in {{ $country['onboarding'] }}</p>
                        <p class="num text-xs text-ink-500">+{{ $country['cost_uplift'] }} employer cost</p>
                        <p class="mt-auto pt-2 text-xs leading-relaxed text-ink-500">{{ $country['note'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.marketing>
