<x-layouts.marketing title="Verification">
    <section class="border-b border-white/10 bg-ink-950">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="flex max-w-3xl flex-col gap-6">
                <x-badge tone="glass" icon="shield" class="w-fit">Consent once, reuse everywhere</x-badge>
                <h1 class="font-display text-4xl leading-[1.05] font-bold tracking-tight text-white sm:text-5xl">
                    A record the candidate owns and the employer can read.
                </h1>
                <p class="text-lg leading-relaxed text-ink-300">
                    Most hiring checks are a green tick with nothing behind it. Ours name the source,
                    the evidence and the date — and the candidate carries the same record into every
                    application instead of starting again.
                </p>
            </div>

            <div class="mt-12 grid gap-px overflow-hidden rounded-2xl bg-white/10 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($checks as $check)
                    <div class="flex flex-col gap-3 bg-ink-950 p-6">
                        <span class="grid size-10 place-items-center rounded-lg bg-white/5 text-signal-400 ring-1 ring-inset ring-white/10">
                            <x-icon :name="$check->icon()" class="size-5" />
                        </span>
                        <p class="font-semibold text-white">{{ $check->label() }}</p>
                        <p class="text-sm leading-relaxed text-ink-400">{{ $check->description() }}</p>
                        <p class="num mt-auto pt-2 text-xs text-signal-400">Source · {{ $check->provider() }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="flex flex-col gap-10 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <p class="eyebrow">A real record</p>
                    <h2 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">This is what an employer sees.</h2>
                </div>
                <a href="{{ route('employer.verification.show') }}" class="btn btn-ink shrink-0">Open the full record</a>
            </div>

            <div class="card mt-10 overflow-hidden">
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-ink-200 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <x-avatar :initials="$record['initials']" size="size-11" />
                        <div>
                            <p class="font-semibold text-ink-900">{{ $record['candidate'] }}</p>
                            <p class="num text-xs text-ink-500">{{ $record['reference'] }} · requested {{ $record['requested'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <x-badge tone="pass" icon="check">{{ $record['cleared'] }} of {{ $record['total'] }} cleared</x-badge>
                        <x-badge tone="warn">{{ $record['total'] - $record['cleared'] }} outstanding</x-badge>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Check</th>
                                <th>Status</th>
                                <th>Data source</th>
                                <th>Evidence</th>
                                <th>Completed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($record['checks'] as $row)
                                <tr>
                                    <td class="font-medium whitespace-nowrap text-ink-900">
                                        <span class="inline-flex items-center gap-2">
                                            <x-icon :name="$row['check']->icon()" class="size-4 text-ink-400" />
                                            {{ $row['check']->label() }}
                                        </span>
                                    </td>
                                    <td><x-status-badge :status="$row['status']" /></td>
                                    <td class="num whitespace-nowrap">{{ $row['source'] }}</td>
                                    <td class="max-w-sm text-ink-600">{{ $row['evidence'] }}</td>
                                    <td class="num whitespace-nowrap text-ink-500">{{ $row['completed'] ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-10 grid gap-5 lg:grid-cols-3">
                @foreach ([
                    ['Consent is per check', 'A candidate approves each check individually and can withdraw one at any time. Nothing runs without it.'],
                    ['Evidence, not verdicts', 'Employers see what the source said. A failed check shows why it failed, so a clerical error is not a rejection.'],
                    ['Checks expire', 'Right-to-work and sanctions results carry an expiry. An old tick is marked expired rather than shown as cleared.'],
                ] as [$title, $copy])
                    <div class="card flex flex-col gap-2 p-6">
                        <p class="font-semibold text-ink-900">{{ $title }}</p>
                        <p class="text-sm leading-relaxed text-ink-500">{{ $copy }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.marketing>
