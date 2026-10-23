<x-layouts.marketing title="For candidates">
    <section class="border-b border-ink-200 bg-white">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-[1.05fr_0.95fr] lg:items-center lg:px-8 lg:py-20">
            <div class="flex min-w-0 flex-col gap-6">
                <x-badge tone="brand" icon="sparkles" class="w-fit">Free, always</x-badge>
                <h1 class="font-display text-4xl leading-[1.05] font-bold tracking-tight sm:text-5xl">
                    Stop applying into the void.
                </h1>
                <p class="max-w-xl text-lg leading-relaxed text-ink-600">
                    Four products, in the order you need them: fix the documents, drill the
                    interview, get matched to roles that fit, and find out why you did not get the
                    last one.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('register', ['account' => 'candidate']) }}" class="btn btn-ink btn-lg">Create a free account</a>
                    <a href="{{ route('candidate.dashboard') }}" class="btn btn-secondary btn-lg">Open the mockup</a>
                </div>
            </div>

            <div class="card flex min-w-0 flex-col gap-5 p-6">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="eyebrow">Job-search readiness</p>
                        <p class="mt-1 text-sm text-ink-500">Where this candidate stands today</p>
                    </div>
                    <x-score :value="78" :size="86" />
                </div>
                <div class="flex flex-col gap-3">
                    <x-meter :value="$cv['overall']" label="CV" :note="'Was '.$cv['previous'].' before the rewrite'" />
                    <x-meter :value="81" label="LinkedIn profile" note="Search impressions up 4.2×" />
                    <x-meter :value="64" label="Cover letter" note="No closing ask, no employer specifics" />
                    <x-meter :value="68" label="Interview delivery" note="Weakest: trade-off narration" />
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-ink-200 bg-ink-50">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Document review, line by line</h2>
            <p class="mt-3 max-w-2xl text-lg text-ink-600">Three documents, the same treatment: a score, the failing line quoted, and the replacement.</p>

            <div class="mt-10 grid gap-5 lg:grid-cols-3">
                @foreach ($documents as $document)
                    <a href="{{ route($document->routeName()) }}" class="card group flex flex-col gap-4 p-6 transition hover:border-brand-300 hover:shadow-md">
                        <span class="grid size-10 place-items-center rounded-xl bg-brand-50 text-brand-600">
                            <x-icon :name="$document->icon()" class="size-5" />
                        </span>
                        <h3 class="text-lg font-bold tracking-tight group-hover:text-brand-700">{{ $document->label() }} review</h3>
                        <p class="text-sm leading-relaxed text-ink-500">{{ $document->description() }}</p>
                        <span class="mt-auto inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700">
                            Open the mockup
                            <x-icon name="arrow-right" class="size-3.5" />
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-b border-ink-200 bg-white">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-20">
            <div class="flex min-w-0 flex-col gap-5">
                <p class="eyebrow">Interview preparation</p>
                <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Four tracks, and the one you keep failing.</h2>
                <p class="text-lg leading-relaxed text-ink-600">
                    Voice drills scored on structure, pace and filler words — plus the content
                    itself. After a real interview, the employer’s scorecard comes back here and
                    sets your next drill.
                </p>
                <a href="{{ route('candidate.interview-prep.index') }}" class="btn btn-primary w-fit">Open interview prep</a>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                @foreach ($tracks as $track)
                    <div class="card flex flex-col gap-3 p-5">
                        <div class="flex items-start justify-between gap-3">
                            <h3 class="font-semibold text-ink-900">{{ $track['name'] }}</h3>
                            <span class="num text-sm font-bold text-ink-900">{{ $track['last_score'] }}</span>
                        </div>
                        <x-meter :value="$track['last_score']" />
                        <p class="text-xs leading-relaxed text-ink-500">{{ $track['detail'] }}</p>
                        <p class="mt-auto text-xs font-semibold text-warn-700">Weakest: {{ $track['weakest'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-ink-950">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:items-center lg:px-8 lg:py-20">
            <div class="flex min-w-0 flex-col gap-5 text-white">
                <p class="eyebrow text-signal-400">Post-interview feedback</p>
                <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Find out why, not just that.</h2>
                <p class="text-lg leading-relaxed text-ink-300">
                    Employers on the platform return a structured scorecard against their own bar.
                    You see which dimensions cleared it, which did not, and what the panel actually
                    wrote.
                </p>
                <a href="{{ route('candidate.feedback') }}" class="btn btn-signal w-fit">See a feedback report</a>
            </div>

            <div class="card min-w-0 p-6">
                <div class="flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate font-semibold">{{ $feedback['role'] }}</p>
                        <p class="truncate text-xs text-ink-500">{{ $feedback['company'] }} · {{ $feedback['interview'] }}</p>
                    </div>
                    <x-badge tone="stop">{{ $feedback['outcome'] }}</x-badge>
                </div>

                <div class="mt-5 flex flex-col gap-3.5">
                    @foreach ($feedback['dimensions'] as $dimension)
                        <x-meter
                            :value="$dimension['score']"
                            :label="$dimension['name']"
                            :bar="$dimension['bar']"
                            :tone="$dimension['verdict'] === 'above' ? 'signal' : 'stop'"
                            :note="$dimension['verdict'] === 'above' ? 'Above their bar of '.$dimension['bar'] : 'Below their bar of '.$dimension['bar']"
                        />
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-layouts.marketing>
