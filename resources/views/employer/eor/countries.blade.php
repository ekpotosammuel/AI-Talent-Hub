<x-layouts.app title="Country coverage" side="employer">
    <a href="{{ route('employer.eor.index') }}" class="inline-flex w-fit items-center gap-1.5 text-sm text-ink-500 hover:text-ink-900">
        <x-icon name="arrow-right" class="size-3.5 rotate-180" />
        Back to employer of record
    </a>

    <x-page-header
        title="Country coverage"
        description="Where we can be the legal employer, what it costs, and how long onboarding takes. Our margin is {{ (int) $margin }}% on top."
        eyebrow="Employ & manage"
    >
        <x-slot:actions>
            <label class="relative">
                <span class="sr-only">Search countries</span>
                <x-icon name="search" class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-ink-400" />
                <input type="search" class="input pl-9" placeholder="Search countries">
            </label>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat label="Countries covered" value="{{ \App\Support\MockData::eorCountryCount() }}" hint="{{ collect($countries)->where('entity', 'Own entity')->count() }} shown with our own entity" icon="globe" />
        <x-stat label="Fastest onboarding" value="4 days" hint="United Kingdom" icon="clock" tone="pass" />
        <x-stat label="Lowest uplift" value="15%" hint="Nigeria and Kenya" icon="card" tone="pass" />
        <x-stat label="Highest uplift" value="38%" hint="Brazil — 13th salary and FGTS" icon="alert" tone="warn" />
    </div>

    <div class="card overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>Country</th>
                    <th>Entity</th>
                    <th>Onboarding</th>
                    <th>Employer cost uplift</th>
                    <th>Statutory notice</th>
                    <th>Annual leave</th>
                    <th>What is included</th>
                    <th class="text-right">Action</th>
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
                        <td class="max-w-xs text-ink-600">{{ $country['note'] }}</td>
                        <td class="text-right">
                            <a href="{{ route('employer.eor.onboard') }}" class="btn btn-secondary btn-sm">Hire here</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <x-mockup-note>Mockup — eight sample countries stand in for the full list.</x-mockup-note>
</x-layouts.app>
