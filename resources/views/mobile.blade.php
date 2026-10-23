@php
    $statusBar = '<div class="flex items-center justify-between px-5 pt-2.5 pb-1 text-[0.6875rem] font-semibold text-ink-900"><span class="num">9:41</span><span class="flex items-center gap-1"><span>●●●</span><span class="num">5G</span><span>▮</span></span></div>';
@endphp

<x-layouts.marketing title="Mobile screens">
    <section class="border-b border-ink-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="flex max-w-2xl flex-col gap-4">
                    <p class="eyebrow">Mobile apps</p>
                    <h1 class="font-display text-4xl leading-[1.05] font-bold tracking-tight sm:text-5xl">The same two sides, in the hand.</h1>
                    <p class="text-lg leading-relaxed text-ink-600">
                        Candidates live in the match feed and the drill screen; employers live in the
                        pipeline and the verification record. Six screens, one design system.
                    </p>
                </div>

                <div class="flex shrink-0 flex-wrap gap-2">
                    @foreach ([['all', 'All screens'], ['Candidate', 'Candidate'], ['Employer', 'Employer']] as [$value, $label])
                        <button type="button" @class(['btn btn-sm', 'btn-ink' => $loop->first, 'btn-secondary' => ! $loop->first]) data-screen-filter="{{ $value }}">{{ $label }}</button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="bg-ink-100">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="grid justify-items-center gap-x-6 gap-y-12 sm:grid-cols-2 xl:grid-cols-3">

                {{-- 1 · Candidate home --}}
                <figure class="flex flex-col items-center gap-4" data-screen="Candidate">
                    <div class="device">
                        <div class="device-notch"></div>
                        <div class="device-screen flex flex-col bg-white">
                            {!! $statusBar !!}
                            <div class="flex items-center justify-between px-5 pt-2 pb-4">
                                <div>
                                    <p class="text-[0.6875rem] text-ink-500">Good morning</p>
                                    <p class="font-display text-lg font-bold">{{ \Illuminate\Support\Str::before($candidate['name'], ' ') }}</p>
                                </div>
                                <x-avatar :initials="$candidate['initials']" size="size-9" />
                            </div>

                            <div class="mx-4 flex items-center gap-4 rounded-2xl bg-ink-950 p-4 text-white">
                                <x-score :value="$candidate['readiness']" :size="64" tone="signal" />
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-signal-400">{{ $candidate['readiness_band'] }}</p>
                                    <p class="mt-0.5 text-[0.6875rem] leading-snug text-ink-400">Two things stand between you and a clean application.</p>
                                </div>
                            </div>

                            <div class="flex flex-1 flex-col gap-2.5 overflow-hidden px-4 pt-5">
                                <p class="eyebrow text-[0.625rem]">Next up</p>
                                @foreach (array_slice($tasks, 0, 3) as $task)
                                    <div class="flex items-start gap-2.5 rounded-xl border border-ink-200 p-3">
                                        <span @class([
                                            'mt-0.5 grid size-5 shrink-0 place-items-center rounded-full',
                                            'bg-stop-50 text-stop-700' => $task['status'] === 'blocked',
                                            'bg-ink-100 text-ink-500' => $task['status'] !== 'blocked',
                                        ])>
                                            <x-icon :name="$task['status'] === 'blocked' ? 'alert' : 'clock'" class="size-3" />
                                        </span>
                                        <div class="min-w-0">
                                            <p class="truncate text-xs font-semibold text-ink-900">{{ $task['title'] }}</p>
                                            <p class="line-clamp-2 text-[0.6875rem] leading-snug text-ink-500">{{ $task['detail'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <nav class="flex items-center justify-around border-t border-ink-200 px-2 py-3">
                                @foreach ([['home', 'Home', true], ['sparkles', 'Matches', false], ['document', 'Review', false], ['mic', 'Prep', false]] as [$icon, $label, $active])
                                    <span @class(['flex flex-col items-center gap-0.5', 'text-brand-600' => $active, 'text-ink-400' => ! $active])>
                                        <x-icon :name="$icon" class="size-5" />
                                        <span class="text-[0.625rem] font-medium">{{ $label }}</span>
                                    </span>
                                @endforeach
                            </nav>
                        </div>
                    </div>
                    <figcaption class="text-center">
                        <p class="font-semibold text-ink-900">Candidate home</p>
                        <p class="text-sm text-ink-500">Readiness score and the next blocking task.</p>
                    </figcaption>
                </figure>

                {{-- 2 · Match feed --}}
                <figure class="flex flex-col items-center gap-4" data-screen="Candidate">
                    <div class="device">
                        <div class="device-notch"></div>
                        <div class="device-screen flex flex-col bg-white">
                            {!! $statusBar !!}
                            <div class="flex items-center justify-between px-5 pt-2 pb-4">
                                <p class="font-display text-lg font-bold">Matches</p>
                                <x-badge tone="neutral">5 new</x-badge>
                            </div>

                            <div class="flex flex-1 flex-col gap-3 overflow-hidden px-4">
                                <article class="flex flex-col gap-3 rounded-2xl border border-ink-200 p-4 shadow-sm">
                                    <div class="flex items-start justify-between gap-3">
                                        <span class="grid size-10 place-items-center rounded-xl bg-ink-900 text-xs font-bold text-white">{{ $job['company_initials'] }}</span>
                                        <x-score :value="$job['match']" :size="56" />
                                    </div>
                                    <div>
                                        <p class="text-sm leading-snug font-bold text-ink-900">{{ $job['title'] }}</p>
                                        <p class="text-xs text-ink-500">{{ $job['company'] }} · {{ $job['location'] }}</p>
                                    </div>
                                    <p class="num text-xs font-semibold text-ink-900">{{ $job['salary'] }}</p>

                                    <div class="flex flex-col gap-1.5 border-t border-ink-100 pt-3">
                                        @foreach (array_slice($job['why'], 0, 3) as $reason)
                                            <p class="flex items-center gap-2 text-[0.6875rem] text-ink-600">
                                                <span @class([
                                                    'size-1.5 shrink-0 rounded-full',
                                                    'bg-signal-500' => $reason['weight'] === 'Strong',
                                                    'bg-warn-500' => $reason['weight'] === 'Partial',
                                                    'bg-ink-300' => $reason['weight'] === 'Missing',
                                                ])></span>
                                                <span class="truncate">{{ $reason['label'] }}</span>
                                            </p>
                                        @endforeach
                                    </div>
                                </article>

                                <div class="flex gap-2">
                                    <button type="button" class="btn btn-secondary btn-sm flex-1">Skip</button>
                                    <button type="button" class="btn btn-ink btn-sm flex-1">Apply</button>
                                </div>

                                <div class="rounded-2xl border border-ink-200 p-3 opacity-50">
                                    <div class="flex items-start justify-between gap-3">
                                        <span class="grid size-8 place-items-center rounded-lg bg-ink-900 text-[0.625rem] font-bold text-white">LH</span>
                                        <span class="num text-sm font-bold">88</span>
                                    </div>
                                    <p class="mt-2 truncate text-xs font-semibold">Staff Engineer — Platform</p>
                                </div>
                            </div>

                            <nav class="mt-3 flex items-center justify-around border-t border-ink-200 px-2 py-3">
                                @foreach ([['home', 'Home', false], ['sparkles', 'Matches', true], ['document', 'Review', false], ['mic', 'Prep', false]] as [$icon, $label, $active])
                                    <span @class(['flex flex-col items-center gap-0.5', 'text-brand-600' => $active, 'text-ink-400' => ! $active])>
                                        <x-icon :name="$icon" class="size-5" />
                                        <span class="text-[0.625rem] font-medium">{{ $label }}</span>
                                    </span>
                                @endforeach
                            </nav>
                        </div>
                    </div>
                    <figcaption class="text-center">
                        <p class="font-semibold text-ink-900">Match feed</p>
                        <p class="text-sm text-ink-500">One role at a time, with the match reasons.</p>
                    </figcaption>
                </figure>

                {{-- 3 · CV review --}}
                <figure class="flex flex-col items-center gap-4" data-screen="Candidate">
                    <div class="device">
                        <div class="device-notch"></div>
                        <div class="device-screen flex flex-col bg-white">
                            {!! $statusBar !!}
                            <div class="flex items-center justify-between px-5 pt-2 pb-3">
                                <p class="font-display text-lg font-bold">CV review</p>
                                <x-badge tone="stop">{{ collect($cv['issues'])->where('severity', 'high')->count() }} high</x-badge>
                            </div>

                            <div class="mx-4 flex items-center gap-4 rounded-2xl bg-ink-50 p-4">
                                <x-score :value="$cv['overall']" :size="60" />
                                <div class="min-w-0">
                                    <p class="num text-xs font-semibold text-signal-700">▲ {{ $cv['overall'] - $cv['previous'] }} since last version</p>
                                    <p class="num mt-0.5 truncate text-[0.6875rem] text-ink-500">{{ $cv['file'] }}</p>
                                </div>
                            </div>

                            <div class="flex flex-1 flex-col gap-3 overflow-hidden px-4 pt-4">
                                @php($issue = $cv['issues'][0])
                                <div class="flex flex-col gap-2 rounded-2xl border border-ink-200 p-3.5">
                                    <div class="flex items-start gap-2">
                                        <x-badge tone="stop">High</x-badge>
                                        <p class="min-w-0 text-xs leading-snug font-semibold text-ink-900">{{ $issue['title'] }}</p>
                                    </div>

                                    <blockquote class="rounded-lg border-l-2 border-stop-500 bg-stop-50/60 px-3 py-2 text-[0.6875rem] leading-snug text-ink-700 italic">
                                        “{{ \Illuminate\Support\Str::limit($issue['quote'], 90) }}”
                                    </blockquote>

                                    <p class="eyebrow text-[0.625rem] text-signal-700">Replace with</p>
                                    <blockquote class="rounded-lg border-l-2 border-signal-500 bg-signal-200/30 px-3 py-2 text-[0.6875rem] leading-snug text-ink-900">
                                        {{ \Illuminate\Support\Str::limit($issue['fix'], 110) }}
                                    </blockquote>

                                    <button type="button" class="btn btn-ink btn-sm w-full">Apply fix</button>
                                </div>

                                <div class="rounded-2xl border border-ink-200 p-3 opacity-50">
                                    <div class="flex items-center gap-2">
                                        <x-badge tone="stop">High</x-badge>
                                        <p class="truncate text-xs font-semibold">Ten of fourteen bullets…</p>
                                    </div>
                                </div>
                            </div>

                            <nav class="mt-3 flex items-center justify-around border-t border-ink-200 px-2 py-3">
                                @foreach ([['home', 'Home', false], ['sparkles', 'Matches', false], ['document', 'Review', true], ['mic', 'Prep', false]] as [$icon, $label, $active])
                                    <span @class(['flex flex-col items-center gap-0.5', 'text-brand-600' => $active, 'text-ink-400' => ! $active])>
                                        <x-icon :name="$icon" class="size-5" />
                                        <span class="text-[0.625rem] font-medium">{{ $label }}</span>
                                    </span>
                                @endforeach
                            </nav>
                        </div>
                    </div>
                    <figcaption class="text-center">
                        <p class="font-semibold text-ink-900">CV review</p>
                        <p class="text-sm text-ink-500">Issue list with the rewrite inline.</p>
                    </figcaption>
                </figure>

                {{-- 4 · Interview drill --}}
                <figure class="flex flex-col items-center gap-4" data-screen="Candidate">
                    <div class="device">
                        <div class="device-notch"></div>
                        <div class="device-screen flex flex-col bg-ink-950 text-white">
                            <div class="flex items-center justify-between px-5 pt-2.5 pb-1 text-[0.6875rem] font-semibold text-white">
                                <span class="num">9:41</span>
                                <span class="flex items-center gap-1"><span>●●●</span><span class="num">5G</span><span>▮</span></span>
                            </div>

                            <div class="flex items-center justify-between px-5 pt-2 pb-4">
                                <div>
                                    <p class="text-[0.6875rem] text-ink-400">{{ $interview['track'] }}</p>
                                    <p class="num font-display text-lg font-bold text-white">{{ $interview['elapsed'] }}</p>
                                </div>
                                <x-badge tone="glass">{{ $interview['question_number'] }}/{{ $interview['question_total'] }}</x-badge>
                            </div>

                            <div class="flex-1 overflow-hidden px-5">
                                <p class="text-sm leading-snug font-bold text-white">{{ \Illuminate\Support\Str::limit($interview['question'], 150) }}</p>

                                <div class="mt-5 flex flex-col gap-3">
                                    <p class="eyebrow text-[0.625rem] text-signal-400">Live signals</p>
                                    @foreach (array_slice($interview['live_signals'], 0, 3) as $signal)
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-baseline justify-between gap-2">
                                                <span class="text-[0.6875rem] text-ink-300">{{ $signal['label'] }}</span>
                                                <span class="num text-[0.6875rem] font-bold text-white">{{ $signal['score'] }}</span>
                                            </div>
                                            <div class="meter bg-white/10">
                                                <span @class([
                                                    'bg-signal-400' => $signal['score'] >= 75,
                                                    'bg-warn-500' => $signal['score'] >= 55 && $signal['score'] < 75,
                                                    'bg-stop-500' => $signal['score'] < 55,
                                                ]) style="width: {{ $signal['score'] }}%"></span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex flex-col items-center gap-3 px-5 pb-8">
                                <div class="flex h-10 items-center gap-1" aria-hidden="true">
                                    @foreach ([10, 20, 32, 18, 36, 26, 14, 30, 22, 38, 16, 28] as $height)
                                        <span class="w-1 rounded-full bg-signal-400/70" style="height: {{ $height }}px"></span>
                                    @endforeach
                                </div>
                                <button type="button" class="grid size-14 place-items-center rounded-full bg-stop-500 text-white">
                                    <x-icon name="mic" class="size-6" />
                                </button>
                                <p class="text-[0.6875rem] text-ink-400">Tap to pause</p>
                            </div>
                        </div>
                    </div>
                    <figcaption class="text-center">
                        <p class="font-semibold text-ink-900">Interview drill</p>
                        <p class="text-sm text-ink-500">Voice drill with live delivery signals.</p>
                    </figcaption>
                </figure>

                {{-- 5 · Employer pipeline --}}
                <figure class="flex flex-col items-center gap-4" data-screen="Employer">
                    <div class="device">
                        <div class="device-notch"></div>
                        <div class="device-screen flex flex-col bg-ink-50">
                            {!! $statusBar !!}
                            <div class="flex items-center justify-between bg-white px-5 pt-2 pb-3">
                                <div class="min-w-0">
                                    <p class="truncate font-display text-base font-bold">Senior Backend Eng.</p>
                                    <p class="num text-[0.6875rem] text-ink-500">ROLE-221 · 42 in pipeline</p>
                                </div>
                                <x-icon name="filter" class="size-4 shrink-0 text-ink-400" />
                            </div>

                            <div class="flex gap-4 overflow-x-auto border-b border-ink-200 bg-white px-5 scrollbar-none">
                                @foreach (\App\Enums\ApplicationStage::pipeline() as $stage)
                                    <span @class(['tab py-2 text-[0.6875rem]', 'tab-active' => $loop->index === 2])>{{ $stage->label() }}</span>
                                @endforeach
                            </div>

                            <div class="flex flex-1 flex-col gap-2.5 overflow-hidden p-4">
                                @foreach ($pipeline[\App\Enums\ApplicationStage::AiInterview->value] as $person)
                                    <article class="rounded-xl border border-ink-200 bg-white p-3">
                                        <div class="flex items-start gap-2.5">
                                            <x-avatar :initials="$person['initials']" tone="paper" size="size-8" />
                                            <div class="min-w-0 flex-1">
                                                <p class="truncate text-xs font-semibold text-ink-900">{{ $person['name'] }}</p>
                                                <p class="truncate text-[0.6875rem] text-ink-500">{{ $person['location'] }}</p>
                                            </div>
                                            <span class="num shrink-0 rounded-md bg-ink-900 px-1.5 py-0.5 text-[0.625rem] font-bold text-signal-400">{{ $person['match'] }}</span>
                                        </div>
                                        <div class="mt-2 flex flex-wrap gap-1.5">
                                            <x-badge :tone="$person['verified'] === $person['checks'] ? 'pass' : 'warn'" icon="shield">{{ $person['verified'] }}/{{ $person['checks'] }}</x-badge>
                                            @if ($person['ai_score'] !== null)
                                                <x-badge tone="brand" icon="mic">{{ $person['ai_score'] }}</x-badge>
                                            @endif
                                        </div>
                                    </article>
                                @endforeach
                            </div>

                            <nav class="flex items-center justify-around border-t border-ink-200 bg-white px-2 py-3">
                                @foreach ([['home', 'Home', false], ['users', 'Pipeline', true], ['shield', 'Checks', false], ['globe', 'EOR', false]] as [$icon, $label, $active])
                                    <span @class(['flex flex-col items-center gap-0.5', 'text-brand-600' => $active, 'text-ink-400' => ! $active])>
                                        <x-icon :name="$icon" class="size-5" />
                                        <span class="text-[0.625rem] font-medium">{{ $label }}</span>
                                    </span>
                                @endforeach
                            </nav>
                        </div>
                    </div>
                    <figcaption class="text-center">
                        <p class="font-semibold text-ink-900">Pipeline</p>
                        <p class="text-sm text-ink-500">Stage tabs, swipe between them.</p>
                    </figcaption>
                </figure>

                {{-- 6 · Verification --}}
                <figure class="flex flex-col items-center gap-4" data-screen="Employer">
                    <div class="device">
                        <div class="device-notch"></div>
                        <div class="device-screen flex flex-col bg-white">
                            {!! $statusBar !!}
                            <div class="flex items-center gap-3 px-5 pt-2 pb-4">
                                <x-avatar :initials="$verification['initials']" size="size-10" />
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-bold text-ink-900">{{ $verification['candidate'] }}</p>
                                    <p class="num truncate text-[0.6875rem] text-ink-500">{{ $verification['reference'] }}</p>
                                </div>
                                <x-badge tone="pass" icon="check">{{ $verification['cleared'] }}/{{ $verification['total'] }}</x-badge>
                            </div>

                            <div class="flex flex-1 flex-col gap-2 overflow-hidden px-4">
                                @foreach ($verification['checks'] as $check)
                                    <div class="flex items-center gap-2.5 rounded-xl border border-ink-200 p-2.5">
                                        <span @class([
                                            'grid size-7 shrink-0 place-items-center rounded-lg',
                                            'bg-pass-50 text-pass-700' => $check['status'] === \App\Enums\VerificationStatus::Verified,
                                            'bg-warn-50 text-warn-700' => ! $check['status']->isSettled(),
                                        ])>
                                            <x-icon :name="$check['check']->icon()" class="size-3.5" />
                                        </span>
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-xs font-semibold text-ink-900">{{ $check['check']->label() }}</p>
                                            <p class="num truncate text-[0.625rem] text-ink-500">{{ $check['source'] }}</p>
                                        </div>
                                        <x-icon :name="$check['status'] === \App\Enums\VerificationStatus::Verified ? 'check' : 'clock'" @class([
                                            'size-4 shrink-0',
                                            'text-signal-600' => $check['status'] === \App\Enums\VerificationStatus::Verified,
                                            'text-warn-500' => ! $check['status']->isSettled(),
                                        ]) />
                                    </div>
                                @endforeach
                            </div>

                            <nav class="mt-3 flex items-center justify-around border-t border-ink-200 px-2 py-3">
                                @foreach ([['home', 'Home', false], ['users', 'Pipeline', false], ['shield', 'Checks', true], ['globe', 'EOR', false]] as [$icon, $label, $active])
                                    <span @class(['flex flex-col items-center gap-0.5', 'text-brand-600' => $active, 'text-ink-400' => ! $active])>
                                        <x-icon :name="$icon" class="size-5" />
                                        <span class="text-[0.625rem] font-medium">{{ $label }}</span>
                                    </span>
                                @endforeach
                            </nav>
                        </div>
                    </div>
                    <figcaption class="text-center">
                        <p class="font-semibold text-ink-900">Verification</p>
                        <p class="text-sm text-ink-500">Seven checks and their data sources.</p>
                    </figcaption>
                </figure>
            </div>

            <x-mockup-note class="mx-auto mt-12 max-w-xl">
                Mockup — these are design renderings in a device frame, not a running mobile app.
            </x-mockup-note>
        </div>
    </section>
</x-layouts.marketing>
