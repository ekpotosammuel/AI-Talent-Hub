@php
    $steps = [
        1 => ['Who you are', 'Name, location and the hours you can work.'],
        2 => ['What you want', 'Target role, salary floor and how you want to work.'],
        3 => ['Your evidence', 'CV, LinkedIn and the certifications we should verify.'],
        4 => ['Consent to checks', 'Pick which checks to run. You can add more later.'],
    ];
@endphp

<x-layouts.base title="Set up your profile">
    <div class="mx-auto flex w-full max-w-3xl flex-1 flex-col gap-8 px-4 py-10 sm:px-6">
        <div class="flex items-center justify-between gap-4">
            <x-logo />
            <a href="{{ route('candidate.dashboard') }}" class="btn btn-ghost btn-sm">Skip for now</a>
        </div>

        {{-- Progress --}}
        <ol class="flex items-center gap-2">
            @foreach ($steps as $number => [$label, $hint])
                <li class="flex flex-1 flex-col gap-2">
                    <span @class([
                        'h-1 rounded-full',
                        'bg-brand-600' => $number <= $step,
                        'bg-ink-200' => $number > $step,
                    ])></span>
                    <span @class([
                        'text-xs font-semibold',
                        'text-brand-700' => $number === $step,
                        'text-ink-900' => $number < $step,
                        'text-ink-400' => $number > $step,
                    ])>{{ $number }}. {{ $label }}</span>
                </li>
            @endforeach
        </ol>

        <div class="panel flex flex-col gap-7">
            <div>
                <p class="eyebrow">Step {{ $step }} of 4</p>
                <h1 class="mt-1.5 text-2xl font-bold tracking-tight">{{ $steps[$step][0] }}</h1>
                <p class="mt-1 text-sm text-ink-500">{{ $steps[$step][1] }}</p>
            </div>

            @if ($step === 1)
                <div class="grid gap-4 sm:grid-cols-2">
                    <x-field label="Full name" name="name" required>
                        <input id="name" class="input" value="{{ $candidate['name'] }}">
                    </x-field>
                    <x-field label="Location" name="location" required>
                        <input id="location" class="input" value="{{ $candidate['location'] }}">
                    </x-field>
                    <x-field label="Time zone" name="timezone">
                        <input id="timezone" class="input" value="{{ $candidate['timezone'] }}">
                    </x-field>
                    <x-field label="Years of experience" name="years">
                        <input id="years" type="number" class="input" value="{{ $candidate['years_experience'] }}">
                    </x-field>
                </div>
            @elseif ($step === 2)
                <div class="flex flex-col gap-4">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <x-field label="Target role" name="target" required>
                            <input id="target" class="input" value="{{ $candidate['target_role'] }}">
                        </x-field>
                        <x-field label="Salary range" name="salary" hint="We never show this to employers.">
                            <input id="salary" class="input" value="{{ $candidate['target_salary'] }}">
                        </x-field>
                    </div>
                    <x-field label="How you want to work" name="arrangement">
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
            @elseif ($step === 3)
                <div class="flex flex-col gap-4">
                    <label for="cv-upload" class="flex cursor-pointer flex-col items-center gap-2 rounded-xl border-2 border-dashed border-ink-300 bg-ink-50 px-6 py-10 text-center transition hover:border-brand-400 hover:bg-brand-50/40">
                        <x-icon name="upload" class="size-6 text-ink-400" />
                        <span class="text-sm font-semibold text-ink-900">Drop your CV here</span>
                        <span class="text-xs text-ink-500">PDF or Word, up to 10 MB. The review starts straight away.</span>
                        <input id="cv-upload" type="file" class="sr-only">
                    </label>
                    <x-field label="LinkedIn profile" name="linkedin">
                        <input id="linkedin" class="input" value="linkedin.com/in/amara-okonkwo">
                    </x-field>
                    <x-field label="Certifications to verify" name="certs" hint="Credential IDs are checked with the issuing body.">
                        <input id="certs" class="input" value="CKA · Linux Foundation">
                    </x-field>
                </div>
            @else
                <div class="flex flex-col gap-3">
                    @foreach (\App\Enums\VerificationCheck::cases() as $check)
                        <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-ink-200 p-4 transition has-checked:border-brand-400 has-checked:bg-brand-50/50">
                            <input type="checkbox" class="checkbox mt-0.5" @checked($loop->index < 5)>
                            <span class="min-w-0 flex-1">
                                <span class="flex flex-wrap items-center gap-2">
                                    <span class="font-semibold text-ink-900">{{ $check->label() }}</span>
                                    <x-badge tone="neutral">{{ $check->provider() }}</x-badge>
                                </span>
                                <span class="mt-0.5 block text-xs leading-relaxed text-ink-500">{{ $check->description() }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>
            @endif

            <div class="rule flex items-center justify-between gap-3 pt-5">
                <a href="{{ route('onboarding', ['step' => max(1, $step - 1)]) }}" @class(['btn btn-secondary', 'invisible' => $step === 1])>Back</a>
                @if ($step < 4)
                    <a href="{{ route('onboarding', ['step' => $step + 1]) }}" class="btn btn-ink">
                        Continue
                        <x-icon name="arrow-right" class="size-4" />
                    </a>
                @else
                    <a href="{{ route('candidate.dashboard') }}" class="btn btn-ink">
                        Finish and open my dashboard
                        <x-icon name="arrow-right" class="size-4" />
                    </a>
                @endif
            </div>
        </div>

        <x-mockup-note>Mockup — the wizard moves between steps but nothing is saved.</x-mockup-note>
    </div>
</x-layouts.base>
