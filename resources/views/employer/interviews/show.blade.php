@php($scorecard = $interview['scorecard'])

<x-layouts.app title="Interview scorecard" side="employer">
    <a href="{{ route('employer.interviews.index') }}" class="inline-flex w-fit items-center gap-1.5 text-sm text-ink-500 hover:text-ink-900">
        <x-icon name="arrow-right" class="size-3.5 rotate-180" />
        Back to interviews
    </a>

    <div class="card flex flex-wrap items-center gap-6 p-6">
        <x-avatar :initials="$scorecard['initials']" size="size-14" />
        <div class="min-w-0 flex-1">
            <h1 class="text-2xl font-bold tracking-tight text-ink-900">{{ $scorecard['candidate'] }}</h1>
            <p class="mt-0.5 text-sm text-ink-500">{{ $interview['role'] }} · {{ $interview['format'] }}</p>
            <p class="num mt-1 text-xs text-ink-500">Completed in {{ $scorecard['completed_in'] }} · {{ $interview['question_count'] }} questions</p>
        </div>
        <x-score :value="$scorecard['overall']" :size="96" label="Overall" />
        <div class="flex shrink-0 flex-col gap-2">
            <x-badge tone="warn" icon="clock">{{ $scorecard['reviewed_by'] }}</x-badge>
            <button type="button" class="btn btn-primary btn-sm">Approve and advance</button>
            <button type="button" class="btn btn-secondary btn-sm">Request a human screen</button>
        </div>
    </div>

    <div class="grid gap-5 lg:grid-cols-[1.3fr_1fr] lg:items-start">
        <div class="flex min-w-0 flex-col gap-5">
            <section class="card p-6">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h2 class="font-semibold text-ink-900">Scored dimensions</h2>
                    <p class="text-xs text-ink-500">Weighted as configured for this role.</p>
                </div>
                <div class="mt-5 flex flex-col gap-4">
                    @foreach ($scorecard['dimensions'] as $dimension)
                        <x-meter :value="$dimension['score']" :label="$dimension['name']" :note="$dimension['note']" />
                    @endforeach
                </div>
            </section>

            <section class="card p-6">
                <h2 class="font-semibold text-ink-900">Evidence</h2>
                <p class="mt-1 text-sm text-ink-500">Every score points at the moment that earned it. Click a timestamp to play the audio.</p>

                <div class="mt-5 flex flex-col gap-3">
                    @foreach ($scorecard['highlights'] as $highlight)
                        <div class="flex items-start gap-3 rounded-lg border-l-2 border-signal-500 bg-signal-200/20 px-4 py-3">
                            <button type="button" class="num shrink-0 font-semibold text-signal-700 hover:underline">{{ $highlight['at'] }}</button>
                            <p class="min-w-0 text-sm leading-relaxed text-ink-800">{{ $highlight['text'] }}</p>
                        </div>
                    @endforeach

                    @foreach ($scorecard['concerns'] as $concern)
                        <div class="flex items-start gap-3 rounded-lg border-l-2 border-warn-500 bg-warn-50/60 px-4 py-3">
                            <button type="button" class="num shrink-0 font-semibold text-warn-700 hover:underline">{{ $concern['at'] }}</button>
                            <p class="min-w-0 text-sm leading-relaxed text-ink-800">{{ $concern['text'] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <div class="flex min-w-0 flex-col gap-5">
            <div class="card flex flex-col gap-3 p-5">
                <p class="eyebrow">Questions asked</p>
                <ol class="flex flex-col gap-2.5">
                    @foreach ($interview['questions'] as $question)
                        <li class="flex gap-2.5 text-sm leading-relaxed text-ink-700">
                            <span class="num shrink-0 font-semibold text-ink-400">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            {{ $question }}
                        </li>
                    @endforeach
                </ol>
            </div>

            <div class="card flex flex-col gap-3 p-5">
                <p class="eyebrow">Recording</p>
                <div class="flex items-center gap-3 rounded-lg bg-ink-900 px-4 py-3">
                    <button type="button" class="grid size-9 shrink-0 place-items-center rounded-full bg-signal-400 text-ink-900">
                        <x-icon name="play" class="size-4" />
                    </button>
                    <div class="min-w-0 flex-1">
                        <div class="meter bg-white/20">
                            <span class="bg-signal-400" style="width: 38%"></span>
                        </div>
                        <p class="num mt-1.5 text-xs text-ink-400">08:52 / {{ $scorecard['completed_in'] }}</p>
                    </div>
                </div>
                <p class="text-xs leading-relaxed text-ink-500">Audio, transcript and scores are kept for 24 months and are visible to the candidate too.</p>
            </div>

            <div class="card-ink flex flex-col gap-3 p-5">
                <x-icon name="shield" class="size-5 text-signal-400" />
                <p class="font-semibold text-white">Before you decide</p>
                <p class="text-sm leading-relaxed text-ink-300">
                    This score is advisory. The model never saw their name, photo, age, gender or
                    nationality. Nobody is rejected on it alone.
                </p>
            </div>

            <x-mockup-note>Mockup — playback and approvals do nothing.</x-mockup-note>
        </div>
    </div>
</x-layouts.app>
