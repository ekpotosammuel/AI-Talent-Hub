<x-layouts.app title="Talent management" side="employer">
    <x-page-header title="Talent management" description="What happens after the hire: probation close-outs, reviews, renewal dates and retention risk." eyebrow="Employ & manage">
        <x-slot:actions>
            <button type="button" class="btn btn-secondary btn-sm">Schedule reviews</button>
            <button type="button" class="btn btn-ink btn-sm">Export roster</button>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat label="People managed" :value="$roster->count()" hint="Placed through the platform" icon="users" />
        <x-stat label="Exceeding" :value="$roster->where('performance', 'Exceeding')->count()" hint="At their last review" icon="arrow-up" tone="pass" />
        <x-stat label="At risk" :value="$atRisk" hint="Overdue check-in or flagged" icon="alert" tone="stop" />
        <x-stat label="Renewals due" value="1" hint="Within 90 days" icon="calendar" tone="warn" />
    </div>

    @if ($atRisk > 0)
        <div class="flex flex-wrap items-center gap-4 rounded-xl border border-stop-500/30 bg-stop-50 px-5 py-4">
            <x-icon name="alert" class="size-5 shrink-0 text-stop-700" />
            <div class="min-w-0 flex-1">
                <p class="font-semibold text-stop-700">{{ $atRisk }} person needs attention</p>
                <p class="text-sm text-ink-700">{{ $roster->firstWhere('risk', 'high')['name'] }} has no check-in booked and their last review flagged support needed.</p>
            </div>
            <button type="button" class="btn btn-danger btn-sm shrink-0">Book a check-in</button>
        </div>
    @endif

    <section class="card overflow-hidden">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
            <h2 class="font-semibold text-ink-900">Roster</h2>
            <div class="flex gap-1.5">
                @foreach (['All', 'At risk', 'Renewals'] as $filter)
                    <button type="button" @class(['btn btn-sm', 'btn-ink' => $loop->first, 'btn-secondary' => ! $loop->first])>{{ $filter }}</button>
                @endforeach
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Person</th>
                        <th>Country</th>
                        <th>Tenure</th>
                        <th>Engagement</th>
                        <th>Performance</th>
                        <th>Last check-in</th>
                        <th>Next milestone</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roster as $person)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <x-avatar :initials="$person['initials']" tone="paper" size="size-9" />
                                    <div class="min-w-0">
                                        <p class="font-medium text-ink-900">{{ $person['name'] }}</p>
                                        <p class="text-xs text-ink-500">{{ $person['role'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap">
                                <span class="mr-1.5" aria-hidden="true">{{ $person['flag'] }}</span>{{ $person['country'] }}
                            </td>
                            <td class="num whitespace-nowrap">{{ $person['tenure'] }}</td>
                            <td class="whitespace-nowrap">{{ $person['engagement']->label() }}</td>
                            <td>
                                <x-badge :tone="match ($person['performance']) { 'Exceeding' => 'pass', 'On track' => 'brand', default => 'stop' }">
                                    {{ $person['performance'] }}
                                </x-badge>
                            </td>
                            <td @class(['whitespace-nowrap', 'font-medium text-stop-700' => $person['risk'] === 'high'])>{{ $person['check_in'] }}</td>
                            <td class="text-ink-600">{{ $person['next'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <div class="grid gap-5 lg:grid-cols-2">
        <div class="card flex flex-col gap-4 p-6">
            <h2 class="font-semibold text-ink-900">Review cadence</h2>
            <p class="text-sm text-ink-500">Set once per engagement type. We prompt the manager and keep the record.</p>
            <div class="flex flex-col gap-3">
                @foreach ([
                    ['Probation close-out', 'At 3 months', true],
                    ['First review', 'At 6 months', true],
                    ['Annual review', 'Every 12 months', true],
                    ['Contract renewal reminder', '90 days before expiry', true],
                    ['Pulse check', 'Monthly', false],
                ] as [$label, $cadence, $on])
                    <label class="flex items-center justify-between gap-3 rounded-lg border border-ink-200 px-4 py-3">
                        <span class="min-w-0">
                            <span class="block text-sm font-medium text-ink-900">{{ $label }}</span>
                            <span class="num block text-xs text-ink-500">{{ $cadence }}</span>
                        </span>
                        <input type="checkbox" class="checkbox shrink-0" @checked($on)>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="card flex flex-col gap-4 p-6">
            <h2 class="font-semibold text-ink-900">Retention signals</h2>
            <p class="text-sm text-ink-500">What the platform watches between reviews.</p>
            <div class="flex flex-col gap-4">
                @foreach ([
                    ['Check-ins completed on time', 72, 'warn'],
                    ['Probation close-outs on record', 100, 'signal'],
                    ['Contracts renewed before expiry', 88, 'signal'],
                    ['Payroll runs without an exception', 96, 'signal'],
                ] as [$label, $value, $tone])
                    <x-meter :value="$value" :label="$label" :tone="$tone" />
                @endforeach
            </div>
        </div>
    </div>

    <x-mockup-note>Mockup — the roster is a fixed sample and no reviews are scheduled.</x-mockup-note>
</x-layouts.app>
