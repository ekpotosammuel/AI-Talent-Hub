<x-layouts.app title="My verification" side="candidate">
    <x-page-header
        title="My verification record"
        description="Checked once, with your consent, then reused for every application. You can withdraw any check."
        eyebrow="Candidate side"
    >
        <x-slot:actions>
            <button type="button" class="btn btn-secondary btn-sm">
                <x-icon name="download" class="size-4" />
                Export record
            </button>
            <button type="button" class="btn btn-primary btn-sm">
                <x-icon name="upload" class="size-4" />
                Finish right to work
            </button>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-5 lg:grid-cols-[1fr_20rem] lg:items-start">
        <div class="flex min-w-0 flex-col gap-5">
            <div class="card overflow-hidden">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
                    <h2 class="font-semibold text-ink-900">{{ count($checks) }} checks</h2>
                    <div class="flex gap-1.5">
                        <x-badge tone="pass" icon="check">{{ $cleared }} cleared</x-badge>
                        <x-badge tone="warn">{{ count($checks) - $cleared }} outstanding</x-badge>
                    </div>
                </div>

                <ul class="divide-y divide-ink-100">
                    @foreach ($checks as $row)
                        <li class="flex flex-wrap items-start gap-4 px-5 py-4">
                            <span @class([
                                'mt-0.5 grid size-10 shrink-0 place-items-center rounded-xl',
                                'bg-pass-50 text-pass-700' => $row['status'] === \App\Enums\VerificationStatus::Verified,
                                'bg-warn-50 text-warn-700' => in_array($row['status'], [\App\Enums\VerificationStatus::InProgress, \App\Enums\VerificationStatus::Pending], true),
                                'bg-stop-50 text-stop-700' => $row['status'] === \App\Enums\VerificationStatus::Failed,
                            ])>
                                <x-icon :name="$row['check']->icon()" class="size-5" />
                            </span>

                            <div class="min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <p class="font-semibold text-ink-900">{{ $row['check']->label() }}</p>
                                    <x-status-badge :status="$row['status']" />
                                </div>
                                <p class="mt-0.5 text-sm text-ink-600">{{ $row['detail'] }}</p>
                                <p class="num mt-1 text-xs text-ink-400">
                                    Source · {{ $row['check']->provider() }}@if ($row['completed']) · cleared {{ $row['completed'] }}@endif
                                </p>
                            </div>

                            <div class="shrink-0">
                                @if ($row['status'] === \App\Enums\VerificationStatus::Pending)
                                    <button type="button" class="btn btn-primary btn-sm">
                                        <x-icon name="upload" class="size-3.5" />
                                        Upload
                                    </button>
                                @elseif ($row['status'] === \App\Enums\VerificationStatus::Verified)
                                    <button type="button" class="btn btn-ghost btn-sm">Withdraw</button>
                                @else
                                    <span class="num text-xs text-ink-400">Waiting on issuer</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="card flex flex-col gap-3 p-5">
                <p class="eyebrow">Who has seen this record</p>
                @foreach ([
                    ['Northwind Pay', 'Full record · 11 days ago'],
                    ['Lumen Health', 'Identity and employment only · 6 days ago'],
                    ['Kestrel Logistics', 'Full record · 2 weeks ago'],
                ] as [$company, $detail])
                    <div class="flex items-center justify-between gap-3 rounded-lg border border-ink-200 px-4 py-3">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-ink-900">{{ $company }}</p>
                            <p class="truncate text-xs text-ink-500">{{ $detail }}</p>
                        </div>
                        <button type="button" class="btn btn-ghost btn-sm shrink-0">Revoke</button>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex min-w-0 flex-col gap-5">
            <div class="card flex flex-col items-center gap-3 p-6 text-center">
                <x-score :value="(int) round($cleared / count($checks) * 100)" :size="120" label="Record complete" />
                <p class="text-sm text-ink-600">Employers filter on a complete record. Two checks are holding yours back.</p>
            </div>

            <div class="card-ink flex flex-col gap-3 p-5">
                <x-icon name="shield" class="size-5 text-signal-400" />
                <p class="font-semibold text-white">This record is yours</p>
                <p class="text-sm leading-relaxed text-ink-300">
                    It is not tied to one employer or one application. Export it, revoke access, or
                    take it with you if you stop using the platform.
                </p>
            </div>

            <x-mockup-note>Mockup — uploads and revocations do nothing.</x-mockup-note>
        </div>
    </div>
</x-layouts.app>
