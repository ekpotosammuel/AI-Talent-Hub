<x-layouts.app title="Dashboard" side="candidate">
    <x-page-header
        title="Good morning, {{ \Illuminate\Support\Str::before($candidate['name'], ' ') }}"
        description="You are {{ \Illuminate\Support\Str::lower($candidate['readiness_band']) }}. One check and one rewrite stand between you and a clean application."
        eyebrow="Candidate dashboard"
    >
        <x-slot:actions>
            <a href="{{ route('candidate.jobs.index') }}" class="btn btn-primary btn-sm">
                <x-icon name="sparkles" class="size-4" />
                See new matches
            </a>
        </x-slot:actions>
    </x-page-header>

    {{-- Readiness + next actions --}}
    <div class="grid gap-5 lg:grid-cols-[20rem_1fr]">
        <div class="card flex flex-col items-center gap-4 p-6">
            <x-score :value="$candidate['readiness']" label="Job-search readiness" :size="140" :caption="$candidate['readiness_band']" />
            <div class="w-full rule pt-4">
                <div class="flex flex-col gap-3">
                    @foreach ($documents as $document)
                        <x-meter :value="$reviews[$document->value]" :label="$document->label()" />
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card flex flex-col">
            <div class="flex items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
                <h2 class="font-semibold text-ink-900">What to do next</h2>
                <x-badge tone="warn">{{ collect($tasks)->whereIn('status', ['blocked', 'todo'])->count() }} open</x-badge>
            </div>
            <ul class="divide-y divide-ink-100">
                @foreach ($tasks as $task)
                    <li class="flex items-start gap-3.5 px-5 py-4">
                        <span @class([
                            'mt-0.5 grid size-6 shrink-0 place-items-center rounded-full text-xs',
                            'bg-signal-500 text-white' => $task['status'] === 'done',
                            'bg-stop-50 text-stop-700 ring-1 ring-stop-500/30' => $task['status'] === 'blocked',
                            'bg-ink-100 text-ink-500' => $task['status'] === 'todo',
                        ])>
                            <x-icon :name="$task['status'] === 'done' ? 'check' : ($task['status'] === 'blocked' ? 'alert' : 'clock')" class="size-3.5" />
                        </span>
                        <div class="min-w-0 flex-1">
                            <p @class(['font-medium text-ink-900', 'text-ink-400 line-through' => $task['status'] === 'done'])>{{ $task['title'] }}</p>
                            <p class="mt-0.5 text-sm text-ink-500">{{ $task['detail'] }}</p>
                        </div>
                        @if ($task['cta'] && $task['route'])
                            <a href="{{ route($task['route']) }}" class="btn btn-secondary btn-sm shrink-0">{{ $task['cta'] }}</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Matches --}}
    <section class="flex flex-col gap-4">
        <div class="flex items-end justify-between gap-3">
            <h2 class="text-lg font-bold tracking-tight">New matches today</h2>
            <a href="{{ route('candidate.jobs.index') }}" class="link text-sm">See all {{ \App\Support\MockData::jobs()->count() }}</a>
        </div>

        <div class="grid gap-4 lg:grid-cols-3">
            @foreach ($jobs as $job)
                <a href="{{ route('candidate.jobs.show', ['job' => $job['id']]) }}" class="card group flex flex-col gap-3 p-5 transition hover:border-brand-300 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <span class="grid size-10 shrink-0 place-items-center rounded-lg bg-ink-900 text-xs font-bold text-white">{{ $job['company_initials'] }}</span>
                        <x-score :value="$job['match']" :size="52" />
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-ink-900 group-hover:text-brand-700">{{ $job['title'] }}</p>
                        <p class="text-sm text-ink-500">{{ $job['company'] }} · {{ $job['location'] }}</p>
                    </div>
                    <p class="num text-sm font-medium text-ink-700">{{ $job['salary'] }}</p>
                    <div class="mt-auto flex flex-wrap gap-1.5 pt-2">
                        @if ($job['eor_available'])
                            <x-badge tone="brand" icon="globe">EOR</x-badge>
                        @endif
                        @if ($job['verified_employer'])
                            <x-badge tone="pass" icon="shield">Verified</x-badge>
                        @endif
                        <x-badge tone="neutral">{{ $job['source'] }}</x-badge>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Applications + prep --}}
    <div class="grid gap-5 lg:grid-cols-[1.3fr_1fr]">
        <section class="card flex flex-col">
            <div class="flex items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
                <h2 class="font-semibold text-ink-900">Applications in flight</h2>
                <a href="{{ route('candidate.applications') }}" class="link text-sm">Open tracker</a>
            </div>
            <div class="divide-y divide-ink-100">
                @foreach ($applications as $application)
                    <div class="flex items-center gap-3.5 px-5 py-3.5">
                        <x-avatar :initials="$application['company_initials']" tone="paper" size="size-9" />
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-ink-900">{{ $application['role'] }}</p>
                            <p class="truncate text-xs text-ink-500">{{ $application['last_activity'] }}</p>
                        </div>
                        <x-status-badge :status="$application['stage']" class="shrink-0" />
                    </div>
                @endforeach
            </div>
        </section>

        <section class="card flex flex-col">
            <div class="flex items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
                <h2 class="font-semibold text-ink-900">Interview readiness</h2>
                <a href="{{ route('candidate.interview-prep.index') }}" class="link text-sm">Drill</a>
            </div>
            <div class="flex flex-col gap-4 p-5">
                @foreach ($tracks as $track)
                    <x-meter :value="$track['last_score']" :label="$track['name']" :note="'Weakest: '.$track['weakest']" />
                @endforeach
            </div>
        </section>
    </div>

    <x-mockup-note>Mockup — every figure on this screen comes from a fixed sample record.</x-mockup-note>
</x-layouts.app>
