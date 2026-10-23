<x-layouts.app title="Interview prep" side="candidate">
    <x-page-header
        title="Interview preparation"
        description="Drill the track you keep losing points on. Scores from real interviews set the priority."
        eyebrow="Candidate side"
    >
        <x-slot:actions>
            <a href="{{ route('candidate.interview-prep.session') }}" class="btn btn-primary btn-sm">
                <x-icon name="mic" class="size-4" />
                Start a drill
            </a>
        </x-slot:actions>
    </x-page-header>

    {{-- Upcoming --}}
    <div class="card-ink flex flex-col gap-4 p-6 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex min-w-0 items-start gap-4">
            <span class="grid size-11 shrink-0 place-items-center rounded-xl bg-white/10 text-signal-400">
                <x-icon name="calendar" class="size-5" />
            </span>
            <div class="min-w-0">
                <p class="eyebrow text-signal-400">Next interview</p>
                <p class="mt-1 font-semibold text-white">{{ $applications->first()['role'] }}</p>
                <p class="text-sm text-ink-300">{{ $applications->first()['next_step'] }} · {{ $applications->first()['last_activity'] }}</p>
            </div>
        </div>
        <a href="{{ route('candidate.interview-prep.session') }}" class="btn btn-signal shrink-0">Drill system design</a>
    </div>

    {{-- Tracks --}}
    <section class="flex flex-col gap-4">
        <h2 class="text-lg font-bold tracking-tight">Your four tracks</h2>
        <div class="grid gap-4 sm:grid-cols-2">
            @foreach ($tracks as $track)
                <article class="card flex flex-col gap-4 p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <h3 class="font-semibold text-ink-900">{{ $track['name'] }}</h3>
                            <p class="mt-0.5 text-sm leading-relaxed text-ink-500">{{ $track['detail'] }}</p>
                        </div>
                        <x-score :value="$track['last_score']" :size="58" class="shrink-0" />
                    </div>

                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-ink-500">
                        <span class="num">{{ $track['drills_done'] }} of {{ $track['questions'] }} questions drilled</span>
                        <span class="font-semibold text-warn-700">Weakest: {{ $track['weakest'] }}</span>
                    </div>

                    <x-meter :value="$track['drills_done']" :max="$track['questions']" tone="ink" />

                    <div class="mt-auto flex gap-2 pt-1">
                        <a href="{{ route('candidate.interview-prep.session') }}" class="btn btn-secondary btn-sm">
                            <x-icon name="play" class="size-3.5" />
                            Drill
                        </a>
                        <button type="button" class="btn btn-ghost btn-sm">Question bank</button>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    {{-- What the last panel said --}}
    <section class="grid gap-5 lg:grid-cols-[1.2fr_1fr] lg:items-start">
        <div class="card flex flex-col gap-4 p-6">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="eyebrow">Why these are your priorities</p>
                    <h2 class="mt-1 font-semibold text-ink-900">{{ $feedback['company'] }} · {{ $feedback['role'] }}</h2>
                </div>
                <a href="{{ route('candidate.feedback') }}" class="link text-sm">Full report</a>
            </div>

            <div class="flex flex-col gap-3.5">
                @foreach ($feedback['dimensions'] as $dimension)
                    <x-meter
                        :value="$dimension['score']"
                        :label="$dimension['name']"
                        :bar="$dimension['bar']"
                        :tone="$dimension['verdict'] === 'above' ? 'signal' : 'stop'"
                        :note="$dimension['verdict'] === 'above' ? 'Cleared their bar of '.$dimension['bar'] : 'Missed their bar of '.$dimension['bar']"
                    />
                @endforeach
            </div>
        </div>

        <div class="card flex flex-col gap-4 p-6">
            <p class="eyebrow">Three things to work on</p>
            @foreach ($feedback['actions'] as $action)
                <div class="flex items-start gap-3">
                    <span class="num mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-brand-50 text-xs font-bold text-brand-700">{{ $loop->iteration }}</span>
                    <div class="min-w-0">
                        <p class="font-medium text-ink-900">{{ $action['title'] }}</p>
                        <p class="mt-0.5 text-sm leading-relaxed text-ink-600">{{ $action['detail'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <x-mockup-note>Mockup — drills do not record audio and scores are fixed sample values.</x-mockup-note>
</x-layouts.app>
