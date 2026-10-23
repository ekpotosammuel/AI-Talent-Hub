@props(['title' => null])

<x-layouts.base :title="$title" body-class="bg-white">
    <header class="sticky top-0 z-40 border-b border-ink-200/80 bg-white/85 backdrop-blur-md">
        <nav class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-4 py-3.5 sm:px-6 lg:px-8">
            <x-logo />

            <button type="button" class="btn btn-secondary btn-sm lg:hidden" data-nav-toggle="marketing-menu" aria-expanded="false" aria-controls="marketing-menu">
                <x-icon name="menu" class="size-4" />
                Menu
            </button>

            <div id="marketing-menu" class="absolute inset-x-0 top-full hidden flex-col gap-1 border-b border-ink-200 bg-white p-4 shadow-lg lg:static lg:flex lg:flex-1 lg:flex-row lg:items-center lg:justify-between lg:border-0 lg:p-0 lg:shadow-none">
                <div class="flex flex-col gap-1 lg:flex-row lg:items-center lg:gap-1">
                    <x-nav-link :href="route('candidates')" :active="request()->routeIs('candidates')">For candidates</x-nav-link>
                    <x-nav-link :href="route('employers')" :active="request()->routeIs('employers')">For employers</x-nav-link>
                    <x-nav-link :href="route('verification')" :active="request()->routeIs('verification')">Verification</x-nav-link>
                    <x-nav-link :href="route('eor')" :active="request()->routeIs('eor')">Employer of record</x-nav-link>
                    <x-nav-link :href="route('pricing')" :active="request()->routeIs('pricing')">Pricing</x-nav-link>
                    <x-nav-link :href="route('mockups')" :active="request()->routeIs('mockups')">Screens</x-nav-link>
                </div>

                <div class="mt-2 flex flex-col gap-2 border-t border-ink-200 pt-3 lg:mt-0 lg:flex-row lg:items-center lg:border-0 lg:pt-0">
                    <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Log in</a>
                    <a href="{{ route('register') }}" class="btn btn-ink btn-sm">
                        Get started
                        <x-icon name="arrow-right" class="size-3.5" />
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-1">
        <x-flash />
        {{ $slot }}
    </main>

    <footer class="border-t border-ink-200 bg-ink-50">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="grid gap-10 md:grid-cols-[1.4fr_1fr_1fr_1fr]">
                <div class="flex flex-col gap-3">
                    <x-logo />
                    <p class="max-w-xs text-sm text-ink-500">
                        Two sides of the same hire: candidates who are ready, and employers who can prove who they are hiring.
                    </p>
                    <p class="text-xs text-ink-400">Interface mockups — no live data behind these screens.</p>
                </div>

                @foreach ([
                    'Candidates' => [
                        ['For candidates', 'candidates'],
                        ['Match feed', 'candidate.jobs.index'],
                        ['CV review', 'candidate.review.cv'],
                        ['Interview prep', 'candidate.interview-prep.index'],
                    ],
                    'Employers' => [
                        ['For employers', 'employers'],
                        ['Verification', 'verification'],
                        ['AI interviews', 'employer.interviews.index'],
                        ['Employer of record', 'eor'],
                    ],
                    'Platform' => [
                        ['Pricing', 'pricing'],
                        ['All screens', 'mockups'],
                        ['Mobile apps', 'mobile'],
                        ['Admin console', 'admin.dashboard'],
                    ],
                ] as $heading => $links)
                    <div class="flex flex-col gap-2.5">
                        <p class="eyebrow">{{ $heading }}</p>
                        @foreach ($links as [$label, $route])
                            <a href="{{ route($route) }}" class="text-sm text-ink-600 transition hover:text-ink-900">{{ $label }}</a>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <div class="rule mt-10 flex flex-col gap-2 pt-6 text-xs text-ink-500 sm:flex-row sm:items-center sm:justify-between">
                <p>&copy; {{ now()->year }} {{ config('app.name') }}. Employer of record in {{ \App\Support\MockData::eorCountryCount() }}+ countries.</p>
                <p class="num">Placement fee {{ (int) config('talent.placement_fee_percent') }}% · EOR margin {{ (int) config('talent.eor_margin_percent') }}%</p>
            </div>
        </div>
    </footer>
</x-layouts.base>
