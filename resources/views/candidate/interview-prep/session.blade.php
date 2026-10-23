<x-layouts.base title="Mock interview" body-class="bg-ink-950">
    <div class="flex min-h-full flex-col">
        {{-- Session bar --}}
        <header class="flex flex-wrap items-center justify-between gap-4 border-b border-white/10 px-4 py-3.5 sm:px-6">
            <div class="flex min-w-0 items-center gap-4">
                <x-logo inverted compact />
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-white">{{ $interview['track'] }} drill</p>
                    <p class="truncate text-xs text-ink-400">{{ $interview['role_context'] }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <span class="num flex items-center gap-2 rounded-lg bg-white/5 px-3 py-1.5 text-sm font-semibold text-white ring-1 ring-inset ring-white/10">
                    <span class="size-2 animate-pulse rounded-full bg-stop-500"></span>
                    <span data-timer>{{ $interview['elapsed'] }}</span>
                    <span class="text-ink-400">/ {{ $interview['limit'] }}</span>
                </span>
                <button type="button" class="btn btn-secondary btn-sm" data-timer-toggle data-running="true">
                    <x-icon name="pause" class="size-3.5" />
                    <span data-timer-label>Pause</span>
                </button>
                <a href="{{ route('candidate.interview-prep.index') }}" class="btn btn-danger btn-sm">End drill</a>
            </div>
        </header>

        <div class="grid flex-1 gap-px bg-white/10 lg:grid-cols-[1.5fr_1fr]">
            {{-- Question + transcript --}}
            <div class="flex min-w-0 flex-col gap-6 bg-ink-950 p-6 sm:p-8">
                <div class="flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <x-badge tone="glass">Question {{ $interview['question_number'] }} of {{ $interview['question_total'] }}</x-badge>
                        <div class="meter max-w-[12rem] bg-white/10">
                            <span class="bg-signal-400" style="width: {{ (int) round($interview['question_number'] / $interview['question_total'] * 100) }}%"></span>
                        </div>
                    </div>
                    <h1 class="font-display text-2xl leading-snug font-bold text-white sm:text-3xl">{{ $interview['question'] }}</h1>
                </div>

                <div class="flex flex-col gap-2">
                    <p class="eyebrow text-ink-400">Follow-ups queued</p>
                    @foreach ($interview['follow_ups'] as $followUp)
                        <p class="flex gap-2.5 text-sm text-ink-400">
                            <span class="num shrink-0">{{ str_pad((string) ($loop->iteration), 2, '0', STR_PAD_LEFT) }}</span>
                            {{ $followUp }}
                        </p>
                    @endforeach
                </div>

                <div class="flex flex-1 flex-col gap-3">
                    <p class="eyebrow text-ink-400">Transcript</p>
                    <div class="flex flex-col gap-3">
                        @foreach ($interview['transcript'] as $line)
                            <div @class([
                                'max-w-2xl rounded-2xl px-4 py-3 text-sm leading-relaxed',
                                'bg-white/5 text-ink-200 ring-1 ring-inset ring-white/10' => $line['speaker'] === 'interviewer',
                                'ml-auto bg-signal-400 text-ink-900' => $line['speaker'] === 'candidate',
                            ])>
                                <span @class([
                                    'mb-1 block text-xs font-semibold',
                                    'text-ink-400' => $line['speaker'] === 'interviewer',
                                    'text-ink-700' => $line['speaker'] === 'candidate',
                                ])>{{ $line['speaker'] === 'interviewer' ? 'Interviewer' : 'You' }}</span>
                                {{ $line['text'] }}
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Mic --}}
                <div class="flex flex-wrap items-center gap-4 rounded-2xl bg-white/5 p-4 ring-1 ring-inset ring-white/10">
                    <button type="button" class="grid size-12 shrink-0 place-items-center rounded-full bg-stop-500 text-white">
                        <x-icon name="mic" class="size-5" />
                    </button>
                    <div class="flex min-w-0 flex-1 items-center gap-1" aria-hidden="true">
                        @foreach ([8, 16, 28, 20, 34, 24, 12, 30, 22, 38, 18, 26, 14, 32, 20, 10, 24, 16] as $height)
                            <span class="w-1 rounded-full bg-signal-400/70" style="height: {{ $height }}px"></span>
                        @endforeach
                    </div>
                    <p class="text-sm text-ink-400">Recording your answer</p>
                </div>
            </div>

            {{-- Live signals --}}
            <aside class="flex min-w-0 flex-col gap-6 bg-ink-900 p-6 sm:p-8">
                <div>
                    <p class="eyebrow text-signal-400">Live delivery signals</p>
                    <p class="mt-1 text-sm text-ink-400">Updated as you speak. Content is scored after the drill.</p>
                </div>

                <div class="flex flex-col gap-5">
                    @foreach ($interview['live_signals'] as $signal)
                        <div class="flex flex-col gap-1.5">
                            <div class="flex items-baseline justify-between gap-3">
                                <span class="text-sm font-medium text-white">{{ $signal['label'] }}</span>
                                <span class="num text-sm font-bold text-white">{{ $signal['score'] }}</span>
                            </div>
                            <div class="meter bg-white/10">
                                <span @class([
                                    'bg-signal-400' => $signal['score'] >= 75,
                                    'bg-warn-500' => $signal['score'] >= 55 && $signal['score'] < 75,
                                    'bg-stop-500' => $signal['score'] < 55,
                                ]) style="width: {{ $signal['score'] }}%"></span>
                            </div>
                            <p class="text-xs text-ink-400">{{ $signal['note'] }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-auto flex flex-col gap-3 rounded-xl bg-white/5 p-4 ring-1 ring-inset ring-white/10">
                    <p class="eyebrow text-ink-400">Nudge</p>
                    <p class="text-sm leading-relaxed text-ink-200">
                        You picked an append-only ledger but have not said what it costs you. Name the
                        trade-off out loud — that is the dimension you lost points on last time.
                    </p>
                </div>

                <x-mockup-note class="border-white/20 bg-white/5 text-ink-400">
                    Mockup — no microphone is used and nothing is transcribed.
                </x-mockup-note>
            </aside>
        </div>
    </div>
</x-layouts.base>
