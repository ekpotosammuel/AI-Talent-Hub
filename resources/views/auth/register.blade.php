<x-layouts.auth title="Create an account" heading="Pick your side" subheading="Candidate and employer accounts are separate. You can hold both with different email addresses.">
    <form class="flex flex-col gap-6" onsubmit="event.preventDefault()">
        <fieldset class="flex flex-col gap-3">
            <legend class="sr-only">Account type</legend>
            <div class="grid gap-3 sm:grid-cols-2">
                @foreach ($sides as $accountSide)
                    <label class="radio-card">
                        <input type="radio" name="account_type" value="{{ $accountSide->value }}" class="sr-only" @checked($accountSide === $selected)>
                        <span class="flex items-center justify-between gap-2">
                            <span class="font-semibold text-ink-900">{{ $accountSide->label() }}</span>
                            <x-icon :name="$accountSide->value === 'candidate' ? 'sparkles' : 'building'" class="size-4 text-ink-400" />
                        </span>
                        <span class="text-xs leading-relaxed text-ink-500">{{ $accountSide->pitch() }}</span>
                    </label>
                @endforeach
            </div>
        </fieldset>

        <div class="grid gap-4 sm:grid-cols-2">
            <x-field label="Full name" name="name" required>
                <input id="name" name="name" type="text" class="input" placeholder="Amara Okonkwo" autocomplete="name">
            </x-field>
            <x-field label="Work email" name="email" required>
                <input id="email" name="email" type="email" class="input" placeholder="you@company.com" autocomplete="email">
            </x-field>
        </div>

        <x-field label="Company" name="company" hint="Employers only. Leave blank if you are job hunting.">
            <input id="company" name="company" type="text" class="input" placeholder="Northwind Pay" autocomplete="organization">
        </x-field>

        <div class="grid gap-4 sm:grid-cols-2">
            <x-field label="Country" name="country" required>
                <select id="country" name="country" class="input">
                    @foreach (\App\Support\MockData::eorCountries() as $country)
                        <option value="{{ $country['country'] }}">{{ $country['flag'] }} {{ $country['country'] }}</option>
                    @endforeach
                </select>
            </x-field>
            <x-field label="Password" name="password" required hint="At least 12 characters.">
                <input id="password" name="password" type="password" class="input" placeholder="••••••••" autocomplete="new-password">
            </x-field>
        </div>

        <label class="flex items-start gap-2.5 text-sm text-ink-600">
            <input type="checkbox" class="checkbox mt-0.5" id="terms" name="terms">
            <span>I agree to the terms of service and to verification checks being run with my consent, check by check.</span>
        </label>

        <a href="{{ route('onboarding') }}" class="btn btn-ink btn-lg w-full">Create account</a>
    </form>

    <p class="text-sm text-ink-500">
        Already have an account? <a href="{{ route('login') }}" class="link">Log in</a>.
    </p>
</x-layouts.auth>
