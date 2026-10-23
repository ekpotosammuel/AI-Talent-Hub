<x-layouts.app title="Interview feedback" side="candidate">
    <x-page-header
        title="Interview feedback"
        description="What the panel actually scored you on, measured against the bar they set before the interview."
        eyebrow="Candidate side"
    />

    <div class="grid gap-5 lg:grid-cols-[1.4fr_1fr] lg:items-start">
        <div class="flex min-w-0 flex-col gap-5">
            {{-- Report header --}}
            <div class="card flex flex-col gap-5 p-6">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div class="flex min-w-0 items-start gap-4">
                        <x-avatar :initials="$feedback['company_initials']" tone="paper" size="size-12" />
                        <div class="min-w-0">
                            <h2 class="font-semibold text-ink-900">{{ $feedback['role'] }}</h2>
                            <p class="text-sm text-ink-500">{{ $feedback['company'] }} · {{ $feedback['interview'] }}</p>
                        </div>
                    </div>
                    <x-badge tone="stop" class="shrink-0">{{ $feedback['outcome'] }}</x-badge>
                </div>

                <div class="rule flex flex-wrap items-center gap-6 pt-5">
                    <x-score :value="$feedback['overall']" :size="92" label="Your score" />
                    <x-score :value="$feedback['bar']" :size="92" label="Their bar" tone="brand" />
                    <p class="min-w-[14rem] flex-1 text-sm leading-relaxed text-ink-600">{{ $feedback['summary'] }}</p>
                </div>
            </div>

            {{-- Dimensions --}}
            <div class="card p-6">
                <h2 class="font-semibold text-ink-900">Scored dimensions</h2>
                <p class="mt-1 text-sm text-ink-500">The black line marks the bar they set for this role.</p>

                <div class="mt-5 flex flex-col gap-4">
                    @foreach ($feedback['dimensions'] as $dimension)
                        <x-meter
                            :value="$dimension['score']"
                            :label="$dimension['name']"
                            :bar="$dimension['bar']"
                            :tone="$dimension['verdict'] === 'above' ? 'signal' : 'stop'"
                            :note="$dimension['verdict'] === 'above' ? 'Above bar ('.$dimension['bar'].')' : 'Below bar ('.$dimension['bar'].')'"
                        />
                    @endforeach
                </div>
            </div>

            {{-- Quotes --}}
            <div class="card p-6">
                <h2 class="font-semibold text-ink-900">What the interviewers wrote</h2>
                <div class="mt-5 flex flex-col gap-4">
                    @foreach ($feedback['quotes'] as $quote)
                        <figure class="rounded-lg border-l-2 border-ink-300 bg-ink-50 px-4 py-3">
                            <blockquote class="text-sm leading-relaxed text-ink-800">“{{ $quote['text'] }}”</blockquote>
                            <figcaption class="mt-1.5 text-xs text-ink-500">{{ $quote['source'] }}</figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Side rail --}}
        <div class="flex min-w-0 flex-col gap-5">
            <div class="card-ink flex flex-col gap-4 p-6">
                <p class="eyebrow text-signal-400">Do these next</p>
                @foreach ($feedback['actions'] as $action)
                    <div class="flex items-start gap-3">
                        <span class="num mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-signal-400 text-xs font-bold text-ink-900">{{ $loop->iteration }}</span>
                        <div class="min-w-0">
                            <a href="{{ route($action['route']) }}" class="font-medium text-white hover:text-signal-400">{{ $action['title'] }}</a>
                            <p class="mt-0.5 text-sm leading-relaxed text-ink-300">{{ $action['detail'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="card flex flex-col gap-3 p-5">
                <p class="eyebrow">Other reports</p>
                @foreach ($applications as $application)
                    <div class="flex items-center gap-3 rounded-lg border border-ink-200 p-3">
                        <x-avatar :initials="$application['company_initials']" tone="paper" size="size-9" />
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-ink-900">{{ $application['company'] }}</p>
                            <p class="truncate text-xs text-ink-500">{{ $application['role'] }}</p>
                        </div>
                        <x-status-badge :status="$application['stage']" class="shrink-0" />
                    </div>
                @endforeach
            </div>

            <x-mockup-note>Mockup — one sample report, shown for every application.</x-mockup-note>
        </div>
    </div>
</x-layouts.app>
