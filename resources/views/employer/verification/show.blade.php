<x-layouts.app title="Verification record" side="employer">
    <a href="{{ route('employer.verification.index') }}" class="inline-flex w-fit items-center gap-1.5 text-sm text-ink-500 hover:text-ink-900">
        <x-icon name="arrow-right" class="size-3.5 rotate-180" />
        Back to verification
    </a>

    <div class="card flex flex-wrap items-center gap-6 p-6">
        <x-avatar :initials="$record['initials']" size="size-14" />
        <div class="min-w-0 flex-1">
            <h1 class="text-2xl font-bold tracking-tight text-ink-900">{{ $record['candidate'] }}</h1>
            <p class="mt-0.5 text-sm text-ink-500">{{ $record['role'] }}</p>
            <p class="num mt-1 text-xs text-ink-500">{{ $record['reference'] }} · requested {{ $record['requested'] }} · resident in {{ $record['country'] }}, hiring into {{ $record['hiring_country'] }}</p>
        </div>
        <x-score :value="(int) round($record['cleared'] / $record['total'] * 100)" :size="88" label="Cleared" />
        <div class="flex shrink-0 flex-col gap-2">
            <button type="button" class="btn btn-secondary btn-sm">
                <x-icon name="download" class="size-3.5" />
                Export PDF
            </button>
            <button type="button" class="btn btn-ghost btn-sm">Request remaining checks</button>
        </div>
    </div>

    <div class="grid gap-5 lg:grid-cols-[1.5fr_1fr] lg:items-start">
        <section class="card overflow-hidden">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
                <h2 class="font-semibold text-ink-900">Checks</h2>
                <div class="flex gap-1.5">
                    <x-badge tone="pass" icon="check">{{ $record['cleared'] }} cleared</x-badge>
                    <x-badge tone="warn">{{ $record['total'] - $record['cleared'] }} outstanding</x-badge>
                </div>
            </div>

            <ul class="divide-y divide-ink-100">
                @foreach ($record['checks'] as $check)
                    <li class="flex flex-wrap items-start gap-4 px-5 py-4">
                        <span @class([
                            'mt-0.5 grid size-10 shrink-0 place-items-center rounded-xl',
                            'bg-pass-50 text-pass-700' => $check['status'] === \App\Enums\VerificationStatus::Verified,
                            'bg-warn-50 text-warn-700' => ! $check['status']->isSettled(),
                            'bg-stop-50 text-stop-700' => $check['status'] === \App\Enums\VerificationStatus::Failed,
                        ])>
                            <x-icon :name="$check['check']->icon()" class="size-5" />
                        </span>

                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <p class="font-semibold text-ink-900">{{ $check['check']->label() }}</p>
                                <x-status-badge :status="$check['status']" />
                            </div>
                            <p class="mt-1 text-sm leading-relaxed text-ink-700">{{ $check['evidence'] }}</p>
                            <p class="num mt-1 text-xs text-ink-500">
                                Source · {{ $check['source'] }}@if ($check['completed']) · {{ $check['completed'] }}@endif
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </section>

        <div class="flex min-w-0 flex-col gap-5">
            <div class="card flex flex-col gap-4 p-5">
                <p class="eyebrow">Audit trail</p>
                <ol class="flex flex-col gap-3.5">
                    @foreach ($record['timeline'] as $entry)
                        <li class="flex gap-3">
                            <div class="flex flex-col items-center">
                                <span class="mt-1 size-2 shrink-0 rounded-full bg-brand-500"></span>
                                @unless ($loop->last)
                                    <span class="w-px flex-1 bg-ink-200"></span>
                                @endunless
                            </div>
                            <div class="min-w-0 pb-1">
                                <p class="num text-xs font-semibold text-ink-500">{{ $entry['at'] }}</p>
                                <p class="mt-0.5 text-sm leading-relaxed text-ink-700">{{ $entry['text'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>

            <div class="card-ink flex flex-col gap-3 p-5">
                <x-icon name="shield" class="size-5 text-signal-400" />
                <p class="font-semibold text-white">What you are allowed to see</p>
                <p class="text-sm leading-relaxed text-ink-300">
                    The candidate consented to each of these checks individually and can withdraw any
                    of them. You see the evidence the source returned — not raw documents.
                </p>
            </div>

            <x-mockup-note>Mockup — exports and check requests do nothing.</x-mockup-note>
        </div>
    </div>
</x-layouts.app>
