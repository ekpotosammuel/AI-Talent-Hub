<x-layouts.marketing title="Pricing">
    <section class="border-b border-ink-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <div class="flex max-w-2xl flex-col gap-4">
                <p class="eyebrow">Pricing</p>
                <h1 class="font-display text-4xl leading-[1.05] font-bold tracking-tight sm:text-5xl">Candidates never pay.</h1>
                <p class="text-lg leading-relaxed text-ink-600">
                    The hiring side funds the platform. That keeps the incentive straight: we are
                    paid when an employer makes a good hire, not when a candidate buys a course.
                </p>
            </div>

            <div class="mt-12 grid items-start gap-5 lg:grid-cols-3">
                @foreach ($plans as $plan)
                    <div @class([
                        'flex flex-col gap-5 p-7',
                        'card-ink lg:-mt-4 lg:pb-9' => $plan['featured'],
                        'card' => ! $plan['featured'],
                    ])>
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p @class(['eyebrow', 'text-signal-400' => $plan['featured']])>{{ $plan['name'] }}</p>
                                <p @class(['num mt-2 font-display text-4xl font-bold tracking-tight', 'text-white' => $plan['featured']])>{{ $plan['price'] }}</p>
                                <p @class(['text-xs', 'text-ink-400' => $plan['featured'], 'text-ink-500' => ! $plan['featured']])>{{ $plan['cadence'] }}</p>
                            </div>
                            @if ($plan['featured'])
                                <x-badge tone="signal">Most used</x-badge>
                            @endif
                        </div>

                        <p @class(['text-sm leading-relaxed', 'text-ink-300' => $plan['featured'], 'text-ink-600' => ! $plan['featured']])>{{ $plan['pitch'] }}</p>

                        <ul class="flex flex-col gap-2.5">
                            @foreach ($plan['features'] as $feature)
                                <li @class(['flex gap-2.5 text-sm', 'text-ink-200' => $plan['featured'], 'text-ink-700' => ! $plan['featured']])>
                                    <x-icon name="check" @class(['mt-0.5 size-4 shrink-0', 'text-signal-400' => $plan['featured'], 'text-signal-600' => ! $plan['featured']]) />
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>

                        <a href="{{ route($plan['route'], $plan['params']) }}" @class([
                            'btn mt-auto w-full',
                            'btn-signal' => $plan['featured'],
                            'btn-secondary' => ! $plan['featured'],
                        ])>{{ $plan['cta'] }}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-ink-50">
        <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8 lg:py-20">
            <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Questions we get asked</h2>
            <div class="mt-8 flex flex-col gap-4">
                @foreach ([
                    ['Is the candidate side really free?', 'Yes, including the document reviews, interview drills and the verification record. The record belongs to the candidate and moves with them if they leave the platform.'],
                    ['What does the placement fee cover?', 'Direct hires are charged '.(int) config('talent.placement_fee_percent').'% of first-year base, once, on start date. Roles hired through employer of record are not charged a placement fee — the monthly margin covers it.'],
                    ['Can we use our own ATS?', 'Yes. Roles are ingested from Greenhouse, Lever, Ashby, Workable and LinkedIn, and stage changes are written back.'],
                    ['Does the AI decide who gets rejected?', 'No. Interview scores are advisory and every decision has a named human reviewer. Candidates can request a human screen instead at any point.'],
                    ['What happens to interview recordings?', 'Audio, transcript and scores are kept for 24 months and are visible to the candidate as well as the employer.'],
                ] as [$question, $answer])
                    <div class="card p-6">
                        <p class="font-semibold text-ink-900">{{ $question }}</p>
                        <p class="mt-2 text-sm leading-relaxed text-ink-600">{{ $answer }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.marketing>
