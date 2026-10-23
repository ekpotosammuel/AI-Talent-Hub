<x-layouts.auth title="Log in" heading="Welcome back" subheading="One sign-in for both sides. Your account decides which app opens.">
    <form class="flex flex-col gap-5" onsubmit="event.preventDefault()">
        <x-field label="Email" name="email" required>
            <input id="email" name="email" type="email" class="input" placeholder="you@company.com" autocomplete="email" value="amara.okonkwo@example.com">
        </x-field>

        <x-field label="Password" name="password" required>
            <input id="password" name="password" type="password" class="input" placeholder="••••••••" autocomplete="current-password">
        </x-field>

        <div class="flex items-center justify-between gap-3">
            <label class="flex items-center gap-2 text-sm text-ink-600">
                <input type="checkbox" class="checkbox" id="remember" name="remember">
                Keep me signed in
            </label>
            <a href="{{ route('login') }}" class="link text-sm">Forgot password?</a>
        </div>

        <button type="submit" class="btn btn-ink btn-lg w-full">Log in</button>
    </form>

    <div class="flex items-center gap-3">
        <span class="h-px flex-1 bg-ink-200"></span>
        <span class="text-xs font-semibold tracking-wide text-ink-400 uppercase">Or open a mockup</span>
        <span class="h-px flex-1 bg-ink-200"></span>
    </div>

    <div class="grid gap-3 sm:grid-cols-3">
        @foreach ([
            ['candidate.dashboard', 'Candidate app', 'sparkles'],
            ['employer.dashboard', 'Employer app', 'building'],
            ['admin.dashboard', 'Admin console', 'shield'],
        ] as [$route, $label, $icon])
            <a href="{{ route($route) }}" class="btn btn-secondary flex-col gap-1.5 py-4 text-xs">
                <x-icon :name="$icon" class="size-4" />
                {{ $label }}
            </a>
        @endforeach
    </div>

    <p class="text-sm text-ink-500">
        No account yet? <a href="{{ route('register') }}" class="link">Create one</a>.
    </p>
</x-layouts.auth>
