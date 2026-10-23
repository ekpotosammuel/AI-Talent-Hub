@props(['title' => null, 'heading', 'subheading' => null])

<x-layouts.base :title="$title" body-class="bg-white">
    <div class="grid min-h-full lg:grid-cols-2">
        <div class="flex flex-col gap-8 px-4 py-10 sm:px-8 lg:px-16 lg:py-14">
            <x-logo class="w-fit" />

            <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center gap-7">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-ink-900">{{ $heading }}</h1>
                    @if ($subheading)
                        <p class="mt-2 text-sm text-ink-500">{{ $subheading }}</p>
                    @endif
                </div>

                {{ $slot }}
            </div>

            <p class="mx-auto w-full max-w-md text-xs text-ink-400">
                Mockup only — these forms do not submit anywhere.
            </p>
        </div>

        <div class="relative hidden overflow-hidden bg-ink-950 lg:block">
            <div class="ink-grid absolute inset-0 opacity-60"></div>
            <div class="relative flex h-full flex-col justify-between gap-10 px-14 py-14 text-white">
                <p class="eyebrow text-signal-400">Why both sides sign up</p>

                <div class="flex flex-col gap-7">
                    @foreach ([
                        ['94%', 'match on the role Amara applied to, with the four reasons shown.'],
                        ['7 checks', 'cleared before an employer ever opens a pipeline.'],
                        ['42 countries', 'where we can be the legal employer on your behalf.'],
                    ] as [$figure, $copy])
                        <div class="flex flex-col gap-1 border-l-2 border-signal-400 pl-5">
                            <span class="num font-display text-4xl font-bold text-signal-400">{{ $figure }}</span>
                            <span class="max-w-sm text-sm text-ink-300">{{ $copy }}</span>
                        </div>
                    @endforeach
                </div>

                <figure class="max-w-sm">
                    <blockquote class="text-sm text-ink-200">
                        “We stopped asking for references and started reading the verification record. Time to offer dropped by eleven days.”
                    </blockquote>
                    <figcaption class="mt-2 text-xs text-ink-400">Dayo Adeleke · Head of Talent, Northwind Pay</figcaption>
                </figure>
            </div>
        </div>
    </div>
</x-layouts.base>
