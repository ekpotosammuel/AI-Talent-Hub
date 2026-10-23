<x-layouts.app title="Employer of record" side="employer">
    <x-page-header title="Employer of record" description="People we legally employ on your behalf. Contracts, payroll, tax and statutory benefits in their country." eyebrow="Employ & manage">
        <x-slot:actions>
            <a href="{{ route('employer.eor.countries') }}" class="btn btn-secondary btn-sm">Country coverage</a>
            <a href="{{ route('employer.eor.onboard') }}" class="btn btn-ink btn-sm">
                <x-icon name="plus" class="size-4" />
                Onboard someone
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat label="Employed via EOR" :value="$employees->count()" hint="{{ $active }} active" icon="globe" />
        <x-stat label="Countries" :value="$employees->pluck('country')->unique()->count()" hint="Of {{ \App\Support\MockData::eorCountryCount() }} available" icon="globe" />
        <x-stat label="Our margin" value="{{ (int) $margin }}%" hint="Of gross salary, monthly" icon="card" />
        <x-stat label="Onboarding" :value="$employees->where('status', '!=', 'Active')->count()" hint="Documents outstanding" icon="clock" tone="warn" />
    </div>

    <section class="card overflow-hidden">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
            <h2 class="font-semibold text-ink-900">Your EOR employees</h2>
            <p class="num text-xs text-ink-500">Next payroll run 30 Nov</p>
        </div>

        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Country</th>
                        <th>Start</th>
                        <th>Gross</th>
                        <th>Cost to you</th>
                        <th>Contract</th>
                        <th>Status</th>
                        <th>Outstanding</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <x-avatar :initials="$employee['initials']" tone="paper" size="size-9" />
                                    <div class="min-w-0">
                                        <p class="font-medium text-ink-900">{{ $employee['name'] }}</p>
                                        <p class="text-xs text-ink-500">{{ $employee['role'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap">
                                <span class="mr-1.5" aria-hidden="true">{{ $employee['flag'] }}</span>{{ $employee['country'] }}
                            </td>
                            <td class="num whitespace-nowrap">{{ $employee['start'] }}</td>
                            <td class="num whitespace-nowrap">{{ $employee['gross'] }}</td>
                            <td class="num whitespace-nowrap font-semibold text-ink-900">{{ $employee['employer_cost'] }}</td>
                            <td>
                                <x-badge :tone="$employee['contract'] === 'Signed' ? 'pass' : 'warn'">{{ $employee['contract'] }}</x-badge>
                            </td>
                            <td><x-status-badge :status="strtolower(str_replace(' ', '_', $employee['status']))" /></td>
                            <td>
                                @if ($employee['outstanding'])
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach ($employee['outstanding'] as $item)
                                            <x-badge tone="warn">{{ $item }}</x-badge>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-xs text-ink-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <div class="grid gap-5 lg:grid-cols-3">
        @foreach (array_slice($countries, 0, 3) as $country)
            <div class="card flex flex-col gap-2 p-5">
                <span class="text-2xl" aria-hidden="true">{{ $country['flag'] }}</span>
                <p class="font-semibold text-ink-900">{{ $country['country'] }}</p>
                <div class="flex flex-wrap gap-x-4 gap-y-1 text-sm text-ink-600">
                    <span class="num">Onboard {{ $country['onboarding'] }}</span>
                    <span class="num">+{{ $country['cost_uplift'] }}</span>
                </div>
                <p class="mt-auto pt-2 text-xs leading-relaxed text-ink-500">{{ $country['note'] }}</p>
            </div>
        @endforeach
    </div>

    <x-mockup-note>Mockup — payroll figures are sample values and nothing is filed anywhere.</x-mockup-note>
</x-layouts.app>
