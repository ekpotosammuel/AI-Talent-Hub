<x-layouts.marketing title="All screens">
    <section class="border-b border-ink-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="flex max-w-2xl flex-col gap-4">
                <p class="eyebrow">Screen index</p>
                <h1 class="font-display text-4xl leading-[1.05] font-bold tracking-tight sm:text-5xl">Every mockup in this build.</h1>
                <p class="text-lg leading-relaxed text-ink-600">
                    {{ collect($groups)->flatten(1)->count() }} screens across the public site, both apps, the admin console
                    and mobile. All of them are clickable and all of them read from one sample
                    candidate, role and company.
                </p>
            </div>
        </div>
    </section>

    <section class="bg-ink-50">
        <div class="mx-auto flex max-w-7xl flex-col gap-12 px-4 py-14 sm:px-6 lg:px-8">
            @foreach ($groups as $group => $screens)
                <div class="flex flex-col gap-5">
                    <div class="flex items-baseline justify-between gap-3">
                        <h2 class="text-2xl font-bold tracking-tight">{{ $group }}</h2>
                        <span class="num text-sm text-ink-500">{{ count($screens) }} screens</span>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($screens as [$route, $name, $note])
                            <a href="{{ route($route) }}" class="card group flex flex-col gap-1.5 p-5 transition hover:border-brand-300 hover:shadow-md">
                                <div class="flex items-start justify-between gap-3">
                                    <p class="font-semibold text-ink-900 group-hover:text-brand-700">{{ $name }}</p>
                                    <x-icon name="arrow-right" class="mt-1 size-4 shrink-0 text-ink-300 transition group-hover:translate-x-0.5 group-hover:text-brand-600" />
                                </div>
                                <p class="text-sm leading-relaxed text-ink-500">{{ $note }}</p>
                                <p class="num mt-auto pt-2 text-xs text-ink-400">{{ $route }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</x-layouts.marketing>
