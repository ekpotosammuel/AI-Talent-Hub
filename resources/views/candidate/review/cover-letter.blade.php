<x-layouts.app title="Cover letter review" side="candidate">
    <x-page-header title="Document review" description="Paragraph by paragraph: keep it, tighten it, or replace it." eyebrow="Candidate side">
        <x-slot:actions>
            <button type="button" class="btn btn-secondary btn-sm">
                <x-icon name="upload" class="size-4" />
                Upload a new version
            </button>
            <button type="button" class="btn btn-primary btn-sm">Draft from my CV</button>
        </x-slot:actions>
    </x-page-header>

    @include('candidate.review._tabs')

    <div class="grid gap-5 lg:grid-cols-[22rem_1fr] lg:items-start">
        <div class="card flex flex-col gap-5 p-6">
            <div class="flex items-center gap-4">
                <x-score :value="$review['overall']" :size="104" label="Overall" />
                <div class="min-w-0 flex-1">
                    <p class="text-xs text-ink-500">{{ $review['uploaded'] }}</p>
                    <p class="num mt-2 flex items-center gap-1.5 text-xs text-ink-600">
                        <x-icon name="mail" class="size-3.5" />
                        {{ $review['file'] }}
                    </p>
                    <p class="num mt-1 text-xs text-ink-500">{{ $review['word_count'] }} words · {{ $review['read_time'] }}</p>
                </div>
            </div>

            <div class="rule flex flex-col gap-3.5 pt-5">
                @foreach ($review['dimensions'] as $dimension)
                    <x-meter :value="$dimension['score']" :label="$dimension['name']" />
                @endforeach
            </div>

            <p class="rounded-lg bg-ink-900 p-4 text-sm leading-relaxed text-white">{{ $review['verdict'] }}</p>

            <div class="rule flex flex-col gap-2 pt-5">
                <p class="eyebrow">Target</p>
                <p class="text-sm font-medium text-ink-900">{{ $review['target'] }}</p>
            </div>
        </div>

        <div class="flex min-w-0 flex-col gap-3">
            @foreach ($review['paragraphs'] as $paragraph)
                <article class="card overflow-hidden">
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-ink-200 px-5 py-3.5">
                        <p class="font-semibold text-ink-900">{{ $paragraph['label'] }}</p>
                        <x-badge :tone="match ($paragraph['verdict']) { 'keep' => 'pass', 'tighten' => 'warn', default => 'stop' }">
                            {{ ucfirst($paragraph['verdict']) }}
                        </x-badge>
                    </div>

                    <div class="flex flex-col gap-4 p-5">
                        <blockquote @class([
                            'rounded-lg border-l-2 px-4 py-3 text-sm leading-relaxed',
                            'border-pass-500 bg-pass-50/60 text-ink-800' => $paragraph['verdict'] === 'keep',
                            'border-warn-500 bg-warn-50/60 text-ink-700' => $paragraph['verdict'] === 'tighten',
                            'border-stop-500 bg-stop-50/60 text-ink-700 italic' => $paragraph['verdict'] === 'rewrite',
                        ])>{{ $paragraph['text'] }}</blockquote>

                        <p class="flex items-start gap-2 text-sm leading-relaxed text-ink-600">
                            <x-icon name="chat" class="mt-0.5 size-4 shrink-0 text-ink-400" />
                            {{ $paragraph['comment'] }}
                        </p>

                        @if ($paragraph['suggestion'])
                            <div class="flex flex-col gap-1.5">
                                <p class="eyebrow text-signal-700">Suggested replacement</p>
                                <blockquote class="rounded-lg border-l-2 border-signal-500 bg-signal-200/30 px-4 py-3 text-sm leading-relaxed text-ink-900">
                                    {{ $paragraph['suggestion'] }}
                                </blockquote>
                                <div class="mt-1 flex gap-2">
                                    <button type="button" class="btn btn-primary btn-sm">Use this</button>
                                    <button type="button" class="btn btn-ghost btn-sm">Try another</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </article>
            @endforeach

            <x-mockup-note>Mockup — suggestions are fixed sample text.</x-mockup-note>
        </div>
    </div>
</x-layouts.app>
