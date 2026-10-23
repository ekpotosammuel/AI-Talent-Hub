<x-layouts.app title="Verification queue" side="admin">
    <x-page-header title="Verification queue" description="Checks that need an operator: a failed source lookup, a late issuer, or a document to read." eyebrow="Admin console">
        <x-slot:actions>
            <button type="button" class="btn btn-secondary btn-sm">Assign to me</button>
            <button type="button" class="btn btn-ink btn-sm">Re-run failed checks</button>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat label="In queue" :value="count($queue)" hint="Needing an operator" icon="shield" />
        <x-stat label="Oldest" value="6 days" hint="Sanctions re-screen" icon="clock" tone="warn" />
        <x-stat label="Failed" :value="collect($queue)->where('status', \App\Enums\VerificationStatus::Failed)->count()" hint="Source returned no match" icon="alert" tone="stop" />
        <x-stat label="Cleared today" value="187" hint="94.2% first time" icon="check" tone="pass" />
    </div>

    <section class="card overflow-hidden">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
            <h2 class="font-semibold text-ink-900">Queue</h2>
            <div class="flex gap-1.5">
                @foreach (['All', 'Failed', 'Waiting on issuer', 'Waiting on candidate'] as $filter)
                    <button type="button" @class(['btn btn-sm', 'btn-ink' => $loop->first, 'btn-secondary' => ! $loop->first])>{{ $filter }}</button>
                @endforeach
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Candidate</th>
                        <th>Check</th>
                        <th>Data source</th>
                        <th>Waiting</th>
                        <th>Status</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($queue as $item)
                        <tr>
                            <td class="num whitespace-nowrap">{{ $item['reference'] }}</td>
                            <td class="font-medium text-ink-900">{{ $item['candidate'] }}</td>
                            <td class="whitespace-nowrap">
                                <span class="inline-flex items-center gap-2">
                                    <x-icon :name="$item['check']->icon()" class="size-4 text-ink-400" />
                                    {{ $item['check']->label() }}
                                </span>
                            </td>
                            <td class="num whitespace-nowrap">{{ $item['check']->provider() }}</td>
                            <td class="num whitespace-nowrap">{{ $item['waiting'] }}</td>
                            <td><x-status-badge :status="$item['status']" /></td>
                            <td class="text-right">
                                <button type="button" class="btn btn-secondary btn-sm">Review</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="card p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="font-semibold text-ink-900">Record under review</h2>
                <p class="num text-xs text-ink-500">{{ $record['reference'] }} · {{ $record['candidate'] }}</p>
            </div>
            <a href="{{ route('employer.verification.show') }}" class="btn btn-secondary btn-sm">Open full record</a>
        </div>

        <div class="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($record['checks'] as $check)
                <div class="flex flex-col gap-2 rounded-lg border border-ink-200 p-4">
                    <div class="flex items-center justify-between gap-2">
                        <x-icon :name="$check['check']->icon()" class="size-4 text-ink-400" />
                        <x-status-badge :status="$check['status']" />
                    </div>
                    <p class="text-sm font-medium text-ink-900">{{ $check['check']->label() }}</p>
                    <p class="num text-xs text-ink-500">{{ $check['source'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <x-mockup-note>Mockup — queue actions do nothing.</x-mockup-note>
</x-layouts.app>
