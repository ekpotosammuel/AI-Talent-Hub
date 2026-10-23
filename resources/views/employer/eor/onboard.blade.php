@php
    $steps = [
        ['Offer confirmed', 'done', 'Salary, start date and country agreed with the candidate.'],
        ['Compliance check', 'done', 'Role and salary checked against Ghanaian employment law. No blockers.'],
        ['Contract issued', 'done', 'Local contract countersigned by our Ghana entity and sent for signature.'],
        ['Employee documents', 'current', 'Bank details and Ghana Card still outstanding.'],
        ['Statutory registration', 'todo', 'SSNIT tiers 1–3 and PAYE registration.'],
        ['First payroll', 'todo', 'Scheduled for the 30 November cycle.'],
    ];
@endphp

<x-layouts.app title="EOR onboarding" side="employer">
    <a href="{{ route('employer.eor.index') }}" class="inline-flex w-fit items-center gap-1.5 text-sm text-ink-500 hover:text-ink-900">
        <x-icon name="arrow-right" class="size-3.5 rotate-180" />
        Back to employer of record
    </a>

    <x-page-header
        title="Onboarding {{ $employee['name'] }}"
        description="{{ $employee['role'] }} · {{ $employee['flag'] }} {{ $employee['country'] }} · starts {{ $employee['start'] }}"
        eyebrow="Employ & manage"
    >
        <x-slot:actions>
            <button type="button" class="btn btn-secondary btn-sm">Message employee</button>
            <button type="button" class="btn btn-ink btn-sm">Chase documents</button>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-5 lg:grid-cols-[1.4fr_1fr] lg:items-start">
        <div class="flex min-w-0 flex-col gap-5">
            <section class="card p-6">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h2 class="font-semibold text-ink-900">Onboarding steps</h2>
                    <x-badge tone="warn">{{ collect($steps)->where('1', 'done')->count() }} of {{ count($steps) }} complete</x-badge>
                </div>

                <ol class="mt-5 flex flex-col gap-0">
                    @foreach ($steps as [$title, $state, $detail])
                        <li class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <span @class([
                                    'grid size-7 shrink-0 place-items-center rounded-full text-xs',
                                    'bg-signal-500 text-white' => $state === 'done',
                                    'bg-brand-600 text-white ring-4 ring-brand-100' => $state === 'current',
                                    'bg-ink-100 text-ink-400' => $state === 'todo',
                                ])>
                                    <x-icon :name="$state === 'done' ? 'check' : ($state === 'current' ? 'clock' : 'plus')" class="size-3.5" />
                                </span>
                                @unless ($loop->last)
                                    <span @class(['w-px flex-1', 'bg-signal-500' => $state === 'done', 'bg-ink-200' => $state !== 'done'])></span>
                                @endunless
                            </div>
                            <div class="min-w-0 pb-6">
                                <p @class(['font-medium', 'text-ink-900' => $state !== 'todo', 'text-ink-400' => $state === 'todo'])>{{ $title }}</p>
                                <p class="mt-0.5 text-sm leading-relaxed text-ink-500">{{ $detail }}</p>
                                @if ($state === 'current')
                                    <div class="mt-2.5 flex flex-wrap gap-1.5">
                                        @foreach ($employee['outstanding'] as $item)
                                            <x-badge tone="warn" icon="alert">{{ $item }}</x-badge>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ol>
            </section>

            <section class="card p-6">
                <h2 class="font-semibold text-ink-900">Contract terms</h2>
                <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                    @php($country = collect($countries)->firstWhere('country', $employee['country']))
                    @foreach ([
                        'Legal employer' => 'AI Talent Hub Ghana Ltd',
                        'Employment type' => 'Permanent, full time',
                        'Governing law' => $employee['country'],
                        'Statutory notice' => $country['notice'],
                        'Annual leave' => $country['leave'],
                        'Probation' => '3 months',
                    ] as $label => $value)
                        <div class="rounded-lg border border-ink-200 p-4">
                            <dt class="eyebrow">{{ $label }}</dt>
                            <dd class="mt-1 text-sm font-medium text-ink-900">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </section>
        </div>

        <div class="flex min-w-0 flex-col gap-5">
            <div class="card flex flex-col gap-3 p-5">
                <p class="eyebrow">Monthly cost</p>
                @php($country = collect($countries)->firstWhere('country', $employee['country']))
                @foreach ([
                    ['Gross salary', $employee['gross']],
                    ['Statutory employer costs', '+'.$country['cost_uplift']],
                    ['Our margin', '+'.(int) config('talent.eor_margin_percent').'%'],
                ] as [$label, $value])
                    <div class="flex items-center justify-between gap-3 border-b border-ink-100 pb-2.5 last:border-0">
                        <span class="text-sm text-ink-600">{{ $label }}</span>
                        <span class="num text-sm font-medium text-ink-900">{{ $value }}</span>
                    </div>
                @endforeach
                <div class="flex items-center justify-between gap-3 rounded-lg bg-ink-900 px-4 py-3 text-white">
                    <span class="text-sm font-semibold">Total annual cost</span>
                    <span class="num font-bold text-signal-400">{{ $employee['employer_cost'] }}</span>
                </div>
            </div>

            <div class="card flex flex-col gap-3 p-5">
                <p class="eyebrow">Payroll</p>
                <p class="text-sm text-ink-700">{{ $employee['payroll'] }}</p>
                <p class="text-xs leading-relaxed text-ink-500">Paid in local currency on the local cycle. Tax withheld and filed by our entity. You receive one invoice a month.</p>
            </div>

            <x-mockup-note>Mockup — no contract is issued and no payroll is scheduled.</x-mockup-note>
        </div>
    </div>
</x-layouts.app>
