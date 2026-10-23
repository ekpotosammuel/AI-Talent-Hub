<x-layouts.marketing title="Employer of record">
    <section class="border-b border-ink-200 bg-white">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 py-16 sm:px-6 lg:grid-cols-[1fr_0.85fr] lg:items-center lg:px-8 lg:py-20">
            <div class="flex min-w-0 flex-col gap-6">
                <x-badge tone="brand" icon="globe" class="w-fit">{{ \App\Support\MockData::eorCountryCount() }} countries</x-badge>
                <h1 class="font-display text-4xl leading-[1.05] font-bold tracking-tight sm:text-5xl">
                    You found them. We employ them.
                </h1>
                <p class="max-w-xl text-lg leading-relaxed text-ink-600">
                    When the right person lives somewhere you have no entity, we become their legal
                    employer. Local contract, local payroll, local tax and statutory benefits —
                    billed to you monthly at {{ (int) config('talent.eor_margin_percent') }}% of gross.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('employer.eor.index') }}" class="btn btn-ink btn-lg">Open the EOR mockup</a>
                    <a href="{{ route('employer.eor.countries') }}" class="btn btn-secondary btn-lg">Country coverage</a>
                </div>
            </div>

            <div class="card flex min-w-0 flex-col gap-4 p-6">
                <p class="eyebrow">Cost example · Ghana</p>
                @php($example = collect($employees)->firstWhere('country', 'Ghana'))
                <div class="flex flex-col gap-3">
                    @foreach ([
                        ['Gross salary', $example['gross'], 'Paid to the employee'],
                        ['Statutory employer costs', '+17%', 'SSNIT tiers 1–3, levies'],
                        ['Our margin', '+'.(int) config('talent.eor_margin_percent').'%', 'Contract, payroll, compliance'],
                    ] as [$label, $value, $hint])
                        <div class="flex items-start justify-between gap-4 border-b border-ink-100 pb-3 last:border-0">
                            <div>
                                <p class="text-sm font-medium text-ink-900">{{ $label }}</p>
                                <p class="text-xs text-ink-500">{{ $hint }}</p>
                            </div>
                            <p class="num shrink-0 text-sm font-bold text-ink-900">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="flex items-center justify-between gap-4 rounded-lg bg-ink-900 px-4 py-3 text-white">
                    <p class="text-sm font-semibold">Total monthly cost to you</p>
                    <p class="num text-lg font-bold text-signal-400">{{ $example['employer_cost'] }}<span class="text-xs text-ink-400">/yr</span></p>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-ink-200 bg-ink-50">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Coverage, cost and time to onboard</h2>
            <p class="mt-3 max-w-2xl text-lg text-ink-600">A sample of the {{ \App\Support\MockData::eorCountryCount() }} countries we cover. Own entity means we hold the local company; partner means a vetted local provider does.</p>

            <div class="card mt-10 overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Country</th>
                            <th>Entity</th>
                            <th>Onboarding</th>
                            <th>Cost uplift</th>
                            <th>Notice</th>
                            <th>Leave</th>
                            <th class="hidden lg:table-cell">Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($countries as $country)
                            <tr>
                                <td class="font-medium whitespace-nowrap text-ink-900">
                                    <span class="mr-2" aria-hidden="true">{{ $country['flag'] }}</span>{{ $country['country'] }}
                                </td>
                                <td><x-badge :tone="$country['entity'] === 'Own entity' ? 'pass' : 'neutral'">{{ $country['entity'] }}</x-badge></td>
                                <td class="num whitespace-nowrap">{{ $country['onboarding'] }}</td>
                                <td class="num whitespace-nowrap">{{ $country['cost_uplift'] }}</td>
                                <td class="num whitespace-nowrap">{{ $country['notice'] }}</td>
                                <td class="num whitespace-nowrap">{{ $country['leave'] }}</td>
                                <td class="hidden text-ink-500 lg:table-cell">{{ $country['note'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">From offer to first payslip</h2>
            <ol class="mt-10 grid gap-px overflow-hidden rounded-2xl border border-ink-200 bg-ink-200 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['Offer accepted', 'You set salary, start date and country. We confirm what is legal there before anything is signed.'],
                    ['Local contract', 'Drafted under local employment law in the local language, countersigned by our entity.'],
                    ['Onboarding', 'Tax registration, bank details, benefits election and statutory enrolments — 4 to 15 days by country.'],
                    ['Payroll runs', 'Paid in local currency on the local cycle. Tax withheld and filed. You get one monthly invoice.'],
                ] as [$step, $copy])
                    <li class="flex flex-col gap-3 bg-white p-6">
                        <span class="num font-display text-3xl font-bold text-ink-200">0{{ $loop->iteration }}</span>
                        <p class="font-display text-lg font-bold tracking-tight">{{ $step }}</p>
                        <p class="text-sm leading-relaxed text-ink-500">{{ $copy }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>
</x-layouts.marketing>
