<x-layouts.app title="Settings & billing" side="employer">
    <x-page-header title="Settings & billing" :description="$employer['company'].' · '.$employer['industry']" eyebrow="Account" />

    <div class="grid gap-5 lg:grid-cols-[1fr_20rem] lg:items-start">
        <div class="flex min-w-0 flex-col gap-5">
            <section class="card flex flex-col gap-5 p-6">
                <h2 class="font-semibold text-ink-900">Company</h2>
                <div class="flex items-center gap-4">
                    <x-avatar :initials="$employer['company_initials']" tone="ink" size="size-14" />
                    <div class="flex flex-col gap-1">
                        <button type="button" class="btn btn-secondary btn-sm w-fit">Change logo</button>
                        <p class="text-xs text-ink-500">Shown to candidates on every role.</p>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-field label="Company name" name="company">
                        <input id="company" class="input" value="{{ $employer['company'] }}">
                    </x-field>
                    <x-field label="Headquarters" name="hq">
                        <input id="hq" class="input" value="{{ $employer['headquarters'] }}">
                    </x-field>
                    <x-field label="Industry" name="industry">
                        <input id="industry" class="input" value="{{ $employer['industry'] }}">
                    </x-field>
                    <x-field label="Headcount" name="headcount">
                        <input id="headcount" type="number" class="input" value="{{ $employer['headcount'] }}">
                    </x-field>
                </div>
            </section>

            <section class="card flex flex-col gap-4 p-6">
                <h2 class="font-semibold text-ink-900">Hiring countries</h2>
                <p class="text-sm text-ink-500">Where you can employ directly. Anywhere else, we can be the employer of record.</p>
                <div class="flex flex-wrap gap-2">
                    @foreach ($employer['hiring_countries'] as $country)
                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-ink-100 px-2.5 py-1 text-sm text-ink-700 ring-1 ring-inset ring-ink-200">
                            {{ $country }}
                            <button type="button" class="text-ink-400 hover:text-stop-500" aria-label="Remove {{ $country }}">
                                <x-icon name="x" class="size-3" />
                            </button>
                        </span>
                    @endforeach
                    <button type="button" class="btn btn-secondary btn-sm">
                        <x-icon name="plus" class="size-3.5" />
                        Add country
                    </button>
                </div>
            </section>

            <section class="card overflow-hidden">
                <div class="flex items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
                    <h2 class="font-semibold text-ink-900">Seats</h2>
                    <x-badge tone="neutral" class="num">{{ $employer['seats_used'] }} of {{ $employer['seats_total'] }} used</x-badge>
                </div>
                <ul class="divide-y divide-ink-100">
                    @foreach ([
                        ['Dayo Adeleke', 'DA', 'Head of Talent', 'Owner'],
                        ['Priya Raman', 'PR', 'Engineering Manager', 'Hiring manager'],
                        ['Tom Byrne', 'TB', 'Compliance', 'Reviewer'],
                        ['Ana Costa', 'AC', 'Design', 'Hiring manager'],
                    ] as [$name, $initials, $title, $role])
                        <li class="flex items-center gap-3.5 px-5 py-3.5">
                            <x-avatar :initials="$initials" tone="paper" size="size-9" />
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-ink-900">{{ $name }}</p>
                                <p class="text-xs text-ink-500">{{ $title }}</p>
                            </div>
                            <x-badge :tone="$role === 'Owner' ? 'brand' : 'neutral'" class="shrink-0">{{ $role }}</x-badge>
                        </li>
                    @endforeach
                </ul>
                <div class="border-t border-ink-200 px-5 py-3.5">
                    <button type="button" class="btn btn-secondary btn-sm">
                        <x-icon name="plus" class="size-3.5" />
                        Invite teammate
                    </button>
                </div>
            </section>
        </div>

        <div class="flex min-w-0 flex-col gap-5">
            @php($plan = collect($plans)->firstWhere('featured', true))
            <div class="card-ink flex flex-col gap-3 p-5">
                <p class="eyebrow text-signal-400">Current plan</p>
                <p class="num font-display text-3xl font-bold text-white">{{ $plan['price'] }}</p>
                <p class="text-xs text-ink-400">{{ $plan['cadence'] }}</p>
                <p class="num rule border-white/10 pt-3 text-sm text-ink-300">{{ $roles->where('status', 'Live')->count() }} live roles billed this month</p>
                <a href="{{ route('pricing') }}" class="btn btn-signal btn-sm mt-1">Change plan</a>
            </div>

            <div class="card flex flex-col gap-3 p-5">
                <p class="eyebrow">This month</p>
                @foreach ([
                    ['Role subscriptions', '$2,070'],
                    ['Verification checks (41)', '$820'],
                    ['EOR margin', '$3,412'],
                ] as [$label, $amount])
                    <div class="flex items-center justify-between gap-3 border-b border-ink-100 pb-2.5 last:border-0">
                        <span class="text-sm text-ink-600">{{ $label }}</span>
                        <span class="num text-sm font-medium text-ink-900">{{ $amount }}</span>
                    </div>
                @endforeach
                <div class="flex items-center justify-between gap-3 rounded-lg bg-ink-100 px-4 py-3">
                    <span class="text-sm font-semibold text-ink-900">Total</span>
                    <span class="num font-bold text-ink-900">$6,302</span>
                </div>
            </div>

            <div class="card flex flex-col gap-3 p-5">
                <p class="eyebrow">Payment method</p>
                <div class="flex items-center gap-3 rounded-lg border border-ink-200 px-4 py-3">
                    <x-icon name="card" class="size-5 shrink-0 text-ink-400" />
                    <div class="min-w-0 flex-1">
                        <p class="num text-sm font-medium text-ink-900">•••• 4821</p>
                        <p class="text-xs text-ink-500">Expires 04/29</p>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm">Update</button>
            </div>

            <x-mockup-note>Mockup — nothing on this page is saved or billed.</x-mockup-note>
        </div>
    </div>
</x-layouts.app>
