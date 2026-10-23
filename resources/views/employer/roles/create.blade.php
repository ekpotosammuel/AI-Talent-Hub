<x-layouts.app title="Post a role" side="employer">
    <x-page-header title="Post a role" description="Where it publishes, how you intend to employ, and what matching should weigh." eyebrow="Hiring" />

    <form class="grid gap-5 lg:grid-cols-[1fr_20rem] lg:items-start" onsubmit="event.preventDefault()">
        <div class="flex min-w-0 flex-col gap-5">
            <div class="card flex flex-col gap-5 p-6">
                <h2 class="font-semibold text-ink-900">The role</h2>
                <div class="grid gap-4 sm:grid-cols-2">
                    <x-field label="Job title" name="title" required class="sm:col-span-2">
                        <input id="title" class="input" placeholder="Senior Backend Engineer, Payments">
                    </x-field>
                    <x-field label="Location" name="location" required>
                        <input id="location" class="input" placeholder="Remote — EMEA">
                    </x-field>
                    <x-field label="Hiring manager" name="manager">
                        <input id="manager" class="input" value="{{ $employer['name'] }}">
                    </x-field>
                    <x-field label="Salary floor" name="floor" required>
                        <input id="floor" class="input" placeholder="110,000">
                    </x-field>
                    <x-field label="Salary ceiling" name="ceiling" required>
                        <input id="ceiling" class="input" placeholder="135,000">
                    </x-field>
                </div>

                <x-field label="Description" name="description" hint="Paste the full description. Matching reads it; candidates see it unchanged.">
                    <textarea id="description" rows="6" class="input" placeholder="What the person will own in their first 90 days…"></textarea>
                </x-field>
            </div>

            <div class="card flex flex-col gap-4 p-6">
                <h2 class="font-semibold text-ink-900">How you will employ them</h2>
                <div class="grid gap-3 sm:grid-cols-3">
                    @foreach ($engagements as $engagement)
                        <label class="radio-card">
                            <input type="radio" name="engagement" value="{{ $engagement->value }}" class="sr-only" @checked($loop->index === 1)>
                            <span class="font-semibold text-ink-900">{{ $engagement->label() }}</span>
                            <span class="text-xs leading-relaxed text-ink-500">{{ $engagement->description() }}</span>
                        </label>
                    @endforeach
                </div>
                <p class="flex items-start gap-2 text-xs leading-relaxed text-ink-500">
                    <x-icon name="globe" class="mt-px size-3.5 shrink-0" />
                    Employer of record lets you hire in {{ \App\Support\MockData::eorCountryCount() }} countries without a local entity, at {{ (int) config('talent.eor_margin_percent') }}% of gross.
                </p>
            </div>

            <div class="card flex flex-col gap-4 p-6">
                <h2 class="font-semibold text-ink-900">Required verification</h2>
                <p class="text-sm text-ink-500">Candidates below your threshold are not shown to you at all.</p>
                <div class="grid gap-3 sm:grid-cols-2">
                    @foreach (\App\Enums\VerificationCheck::cases() as $check)
                        <label class="flex items-start gap-2.5 rounded-lg border border-ink-200 p-3 transition has-checked:border-brand-400 has-checked:bg-brand-50/50">
                            <input type="checkbox" class="checkbox mt-0.5" @checked($loop->index < 4)>
                            <span class="min-w-0">
                                <span class="block text-sm font-medium text-ink-900">{{ $check->label() }}</span>
                                <span class="num block text-xs text-ink-500">{{ $check->provider() }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex min-w-0 flex-col gap-5">
            <div class="card flex flex-col gap-4 p-5">
                <p class="eyebrow">Publish to</p>
                @foreach ($feeds as $feed)
                    <label class="flex items-center justify-between gap-3 text-sm text-ink-700">
                        <span class="num">{{ $feed }}</span>
                        <input type="checkbox" class="checkbox shrink-0" @checked($loop->index < 3)>
                    </label>
                @endforeach
                <p class="num rule pt-3 text-xs text-ink-500">Syncs every {{ (int) config('talent.job_feeds.sync_minutes') }} minutes.</p>
            </div>

            <div class="card flex flex-col gap-4 p-5">
                <p class="eyebrow">First round</p>
                <label class="flex items-start justify-between gap-3 text-sm text-ink-700">
                    <span>Run an AI interview before human screening</span>
                    <input type="checkbox" class="checkbox mt-0.5 shrink-0" checked>
                </label>
                <a href="{{ route('employer.interviews.create') }}" class="btn btn-secondary btn-sm">Configure questions</a>
            </div>

            <div class="card flex flex-col gap-2.5 p-5">
                <button type="submit" class="btn btn-ink w-full">Publish role</button>
                <button type="button" class="btn btn-secondary w-full">Save as draft</button>
            </div>

            <x-mockup-note>Mockup — this form does not publish anything.</x-mockup-note>
        </div>
    </form>
</x-layouts.app>
