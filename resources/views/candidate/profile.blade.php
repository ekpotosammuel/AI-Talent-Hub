<x-layouts.app title="Profile" side="candidate">
    <x-page-header
        title="Profile"
        description="What matching uses. Keep the targets honest — a wrong salary floor hides roles you would take."
        eyebrow="Candidate side"
    >
        <x-slot:actions>
            <button type="button" class="btn btn-secondary btn-sm">Preview as employer</button>
            <button type="button" class="btn btn-primary btn-sm">Save changes</button>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-5 lg:grid-cols-[1fr_20rem] lg:items-start">
        <form class="flex min-w-0 flex-col gap-5" onsubmit="event.preventDefault()">
            <div class="card flex flex-col gap-5 p-6">
                <h2 class="font-semibold text-ink-900">Who you are</h2>
                <div class="flex items-center gap-4">
                    <x-avatar :initials="$candidate['initials']" size="size-16" />
                    <div class="flex flex-col gap-1">
                        <button type="button" class="btn btn-secondary btn-sm w-fit">Change photo</button>
                        <p class="text-xs text-ink-500">Shown to employers once you apply.</p>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <x-field label="Full name" name="name">
                        <input id="name" class="input" value="{{ $candidate['name'] }}">
                    </x-field>
                    <x-field label="Headline" name="headline">
                        <input id="headline" class="input" value="{{ $candidate['headline'] }}">
                    </x-field>
                    <x-field label="Email" name="email">
                        <input id="email" type="email" class="input" value="{{ $candidate['email'] }}">
                    </x-field>
                    <x-field label="Location" name="location">
                        <input id="location" class="input" value="{{ $candidate['location'] }}">
                    </x-field>
                </div>
            </div>

            <div class="card flex flex-col gap-5 p-6">
                <h2 class="font-semibold text-ink-900">What you are looking for</h2>
                <div class="grid gap-4 sm:grid-cols-2">
                    <x-field label="Target role" name="target_role">
                        <input id="target_role" class="input" value="{{ $candidate['target_role'] }}">
                    </x-field>
                    <x-field label="Salary range" name="salary" hint="Never shown to employers.">
                        <input id="salary" class="input" value="{{ $candidate['target_salary'] }}">
                    </x-field>
                    <x-field label="Years of experience" name="years">
                        <input id="years" type="number" class="input" value="{{ $candidate['years_experience'] }}">
                    </x-field>
                    <x-field label="Time zone" name="timezone">
                        <input id="timezone" class="input" value="{{ $candidate['timezone'] }}">
                    </x-field>
                </div>

                <x-field label="Open to" name="open_to">
                    <div class="mt-1 grid gap-3 sm:grid-cols-3">
                        @foreach ($candidate['open_to'] as $option)
                            <label class="radio-card">
                                <input type="checkbox" class="sr-only" checked>
                                <span class="text-sm font-medium text-ink-900">{{ $option }}</span>
                            </label>
                        @endforeach
                    </div>
                </x-field>
            </div>

            <div class="card flex flex-col gap-4 p-6">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h2 class="font-semibold text-ink-900">Skills</h2>
                    <p class="text-xs text-ink-500">Green skills are evidenced by a verified employment check.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @foreach ($candidate['skills'] as $skill)
                        <span @class([
                            'inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1 text-sm',
                            'bg-pass-50 text-pass-700 ring-1 ring-inset ring-pass-500/30' => $loop->index < 5,
                            'bg-ink-100 text-ink-700 ring-1 ring-inset ring-ink-200' => $loop->index >= 5,
                        ])>
                            @if ($loop->index < 5)
                                <x-icon name="check" class="size-3.5" />
                            @endif
                            {{ $skill }}
                            <button type="button" class="text-ink-400 hover:text-stop-500" aria-label="Remove {{ $skill }}">
                                <x-icon name="x" class="size-3" />
                            </button>
                        </span>
                    @endforeach
                    <button type="button" class="btn btn-secondary btn-sm">
                        <x-icon name="plus" class="size-3.5" />
                        Add skill
                    </button>
                </div>
            </div>
        </form>

        <div class="flex min-w-0 flex-col gap-5">
            <div class="card flex flex-col gap-4 p-5">
                <div class="flex items-center justify-between gap-3">
                    <p class="eyebrow">Profile strength</p>
                    <span class="num text-sm font-bold text-ink-900">{{ $candidate['profile_strength'] }}</span>
                </div>
                <x-meter :value="$candidate['profile_strength']" />
                <ul class="flex flex-col gap-2 text-sm text-ink-600">
                    @foreach ([
                        ['Verified employment history', true],
                        ['CV reviewed in the last 30 days', true],
                        ['LinkedIn connected', true],
                        ['Right to work cleared', false],
                        ['Two references on file', true],
                    ] as [$item, $done])
                        <li class="flex items-start gap-2">
                            <x-icon :name="$done ? 'check' : 'x'" @class(['mt-0.5 size-4 shrink-0', 'text-signal-600' => $done, 'text-stop-500' => ! $done]) />
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="card flex flex-col gap-3 p-5">
                <p class="eyebrow">Privacy</p>
                @foreach ([
                    ['Hide me from my current employer', true],
                    ['Let verified employers contact me', true],
                    ['Show salary expectations', false],
                ] as [$label, $on])
                    <label class="flex items-start justify-between gap-3 text-sm text-ink-700">
                        <span>{{ $label }}</span>
                        <input type="checkbox" class="checkbox mt-0.5 shrink-0" @checked($on)>
                    </label>
                @endforeach
            </div>

            <x-mockup-note>Mockup — nothing on this form is saved.</x-mockup-note>
        </div>
    </div>
</x-layouts.app>
