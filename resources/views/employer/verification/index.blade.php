<x-layouts.app title="Verification" side="employer">
    <x-page-header title="Verification" description="Seven checks against named data sources. Candidates consent check by check, and the record follows them." eyebrow="Trust">
        <x-slot:actions>
            <button type="button" class="btn btn-ink btn-sm">
                <x-icon name="plus" class="size-4" />
                Request checks
            </button>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat label="Records open" value="12" hint="Across all live roles" icon="shield" />
        <x-stat label="Cleared first time" value="94.2%" hint="Platform average" icon="check" tone="pass" />
        <x-stat label="Median turnaround" value="2.1 days" hint="Consent to cleared" icon="clock" />
        <x-stat label="Waiting on candidate" value="3" hint="Documents not yet uploaded" icon="alert" tone="warn" />
    </div>

    {{-- Check types --}}
    <section class="card p-6">
        <h2 class="font-semibold text-ink-900">The checks and their sources</h2>
        <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($checks as $check)
                <div class="flex flex-col gap-2 rounded-lg border border-ink-200 p-4">
                    <span class="grid size-9 place-items-center rounded-lg bg-ink-900 text-signal-400">
                        <x-icon :name="$check->icon()" class="size-4" />
                    </span>
                    <p class="text-sm font-semibold text-ink-900">{{ $check->label() }}</p>
                    <p class="text-xs leading-relaxed text-ink-500">{{ $check->description() }}</p>
                    <p class="num mt-auto pt-1 text-xs font-semibold text-brand-700">{{ $check->provider() }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Records --}}
    <section class="card overflow-hidden">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
            <h2 class="font-semibold text-ink-900">Candidate records</h2>
            <div class="flex gap-1.5">
                @foreach (['All', 'Cleared', 'Outstanding'] as $filter)
                    <button type="button" @class(['btn btn-sm', 'btn-ink' => $loop->first, 'btn-secondary' => ! $loop->first])>{{ $filter }}</button>
                @endforeach
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Candidate</th>
                        <th>Reference</th>
                        <th>Progress</th>
                        <th>Outstanding</th>
                        <th class="text-right">Record</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <x-avatar :initials="$record['initials']" tone="paper" size="size-9" />
                                <div class="min-w-0">
                                    <p class="font-medium text-ink-900">{{ $record['candidate'] }}</p>
                                    <p class="text-xs text-ink-500">{{ $record['role'] }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="num whitespace-nowrap">{{ $record['reference'] }}</td>
                        <td class="w-48">
                            <x-meter :value="$record['cleared']" :max="$record['total']" tone="signal" />
                        </td>
                        <td>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach (collect($record['checks'])->reject(fn ($c) => $c['status'] === \App\Enums\VerificationStatus::Verified) as $outstanding)
                                    <x-badge tone="warn">{{ $outstanding['check']->label() }}</x-badge>
                                @endforeach
                            </div>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('employer.verification.show', ['reference' => $record['reference']]) }}" class="btn btn-secondary btn-sm">Open</a>
                        </td>
                    </tr>

                    @foreach ($pipeline[\App\Enums\ApplicationStage::TeamInterview->value] as $person)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <x-avatar :initials="$person['initials']" tone="paper" size="size-9" />
                                    <div class="min-w-0">
                                        <p class="font-medium text-ink-900">{{ $person['name'] }}</p>
                                        <p class="text-xs text-ink-500">{{ $person['location'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="num whitespace-nowrap text-ink-500">VER-2026-10-04{{ 20 + $loop->index }}</td>
                            <td class="w-48">
                                <x-meter :value="$person['verified']" :max="$person['checks']" tone="signal" />
                            </td>
                            <td>
                                @if ($person['verified'] === $person['checks'])
                                    <x-badge tone="pass" icon="check">Complete</x-badge>
                                @else
                                    <x-badge tone="warn">{{ $person['checks'] - $person['verified'] }} outstanding</x-badge>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('employer.verification.show') }}" class="btn btn-secondary btn-sm">Open</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <x-mockup-note>Mockup — one sample record stands in for every candidate.</x-mockup-note>
</x-layouts.app>
