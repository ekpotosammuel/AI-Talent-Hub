<x-layouts.app title="CV review" side="candidate">
    <x-page-header title="Document review" description="Upload once. Every issue comes with the line that caused it and the replacement." eyebrow="Candidate side">
        <x-slot:actions>
            <button type="button" class="btn btn-secondary btn-sm">
                <x-icon name="upload" class="size-4" />
                Upload a new version
            </button>
            <button type="button" class="btn btn-primary btn-sm">Apply all fixes</button>
        </x-slot:actions>
    </x-page-header>

    @include('candidate.review._tabs')

    {{-- Scores --}}
    <div class="grid gap-5 lg:grid-cols-[22rem_1fr]">
        <div class="card flex flex-col gap-5 p-6">
            <div class="flex items-center gap-4">
                <x-score :value="$review['overall']" :size="104" label="Overall" />
                <div class="min-w-0 flex-1">
                    <p class="num text-sm font-semibold text-signal-700">▲ {{ $review['overall'] - $review['previous'] }} since last version</p>
                    <p class="mt-1 text-xs text-ink-500">{{ $review['uploaded'] }}</p>
                    <p class="num mt-2 flex items-center gap-1.5 text-xs text-ink-600">
                        <x-icon name="document" class="size-3.5" />
                        {{ $review['file'] }} · {{ $review['pages'] }} pages
                    </p>
                </div>
            </div>

            <div class="rule flex flex-col gap-3.5 pt-5">
                <x-meter :value="$review['ats_parse']" label="ATS parse" note="How cleanly the machine reads it" />
                <x-meter :value="$review['recruiter_scan']" label="Six-second scan" note="What a recruiter takes from page one" />
                <x-meter :value="$review['role_fit']" label="Fit for the target role" note="Against JOB-4821" />
            </div>

            <p class="rounded-lg bg-ink-900 p-4 text-sm leading-relaxed text-white">{{ $review['verdict'] }}</p>
        </div>

        <div class="flex min-w-0 flex-col gap-5">
            {{-- Section scores --}}
            <div class="card p-5">
                <h2 class="font-semibold text-ink-900">Section by section</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    @foreach ($review['sections'] as $section)
                        <x-meter :value="$section['score']" :label="$section['name']" :note="$section['note']" />
                    @endforeach
                </div>
            </div>

            {{-- Keywords --}}
            <div class="card p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h2 class="font-semibold text-ink-900">Role keywords</h2>
                    <p class="num text-xs text-ink-500">{{ collect($review['keywords'])->where('present', true)->count() }} of {{ count($review['keywords']) }} present</p>
                </div>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($review['keywords'] as $keyword)
                        <span @class([
                            'inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1 text-sm',
                            'bg-pass-50 text-pass-700 ring-1 ring-inset ring-pass-500/30' => $keyword['present'],
                            'bg-stop-50 text-stop-700 ring-1 ring-inset ring-stop-500/30' => ! $keyword['present'],
                        ])>
                            <x-icon :name="$keyword['present'] ? 'check' : 'x'" class="size-3.5" />
                            {{ $keyword['term'] }}
                            @if ($keyword['present'])
                                <span class="num text-xs opacity-70">×{{ $keyword['count'] }}</span>
                            @endif
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Issues --}}
    <section class="flex flex-col gap-4">
        <div class="flex flex-wrap items-end justify-between gap-3">
            <h2 class="text-lg font-bold tracking-tight">{{ count($review['issues']) }} issues, worst first</h2>
            <div class="flex gap-1.5">
                <x-badge tone="stop">{{ collect($review['issues'])->where('severity', 'high')->count() }} high</x-badge>
                <x-badge tone="warn">{{ collect($review['issues'])->where('severity', 'medium')->count() }} medium</x-badge>
                <x-badge tone="neutral">{{ collect($review['issues'])->where('severity', 'low')->count() }} low</x-badge>
            </div>
        </div>

        <div class="flex flex-col gap-3">
            @foreach ($review['issues'] as $issue)
                <article class="card overflow-hidden">
                    <button type="button" class="flex w-full items-center gap-3.5 p-5 text-left transition hover:bg-ink-50" data-disclosure="issue-{{ $loop->index }}" aria-expanded="true">
                        <x-badge :tone="match ($issue['severity']) { 'high' => 'stop', 'medium' => 'warn', default => 'neutral' }" class="shrink-0">
                            {{ ucfirst($issue['severity']) }}
                        </x-badge>
                        <span class="min-w-0 flex-1">
                            <span class="block font-semibold text-ink-900">{{ $issue['title'] }}</span>
                            <span class="block text-xs text-ink-500">{{ $issue['where'] }}</span>
                        </span>
                        <x-icon name="arrow-right" class="size-4 shrink-0 rotate-90 text-ink-400 transition" data-disclosure-caret />
                    </button>

                    <div id="issue-{{ $loop->index }}" class="flex flex-col gap-4 border-t border-ink-200 p-5">
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

                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <p class="flex max-w-xl items-start gap-2 text-xs leading-relaxed text-ink-500">
                                <x-icon name="alert" class="mt-px size-3.5 shrink-0" />
                                {{ $issue['why'] }}
                            </p>
                            <div class="flex shrink-0 gap-2">
                                <button type="button" class="btn btn-primary btn-sm">Apply fix</button>
                                <button type="button" class="btn btn-ghost btn-sm">Dismiss</button>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <x-mockup-note>Mockup — uploads, fixes and dismissals do nothing.</x-mockup-note>
</x-layouts.app>
