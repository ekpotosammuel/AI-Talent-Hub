<x-layouts.app :title="$role['title']" side="employer">
    <a href="{{ route('employer.roles.index') }}" class="inline-flex w-fit items-center gap-1.5 text-sm text-ink-500 hover:text-ink-900">
        <x-icon name="arrow-right" class="size-3.5 rotate-180" />
        Back to roles
    </a>

    <x-page-header :title="$role['title']" :description="$role['location'].' · '.$role['engagement']->label().' · '.$role['salary']" eyebrow="{{ $role['id'] }}">
        <x-slot:actions>
            <a href="{{ route('employer.pipeline') }}" class="btn btn-primary btn-sm">Open pipeline board</a>
            <button type="button" class="btn btn-secondary btn-sm">Edit role</button>
            <button type="button" class="btn btn-ghost btn-sm">Pause</button>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
        <x-stat label="Pipeline" :value="$role['pipeline']" hint="{{ $role['matched'] }} above match threshold" icon="users" />
        <x-stat label="Interviewing" :value="$role['in_interview']" hint="AI and team rounds" icon="mic" />
        <x-stat label="Offers" :value="$role['offers']" hint="Awaiting signature" icon="check" tone="pass" />
        <x-stat label="Verified share" value="{{ $role['verified_share'] }}%" hint="Of the current pipeline" icon="shield" tone="pass" />
        <x-stat label="Days to offer" :value="$role['days_to_offer']" hint="Median for this role" icon="clock" />
    </div>

    {{-- Funnel --}}
    <section class="card p-6">
        <h2 class="font-semibold text-ink-900">Funnel</h2>
        <div class="mt-5 flex flex-col gap-3">
            @php($stageCounts = collect($stages)->mapWithKeys(fn ($stage) => [$stage->value => count($pipeline[$stage->value] ?? [])]))
            @php($widest = max(1, $stageCounts->max()))
            @foreach ($stages as $stage)
                <div class="flex items-center gap-4">
                    <span class="w-32 shrink-0 text-sm font-medium text-ink-700">{{ $stage->label() }}</span>
                    <div class="h-8 min-w-0 flex-1">
                        <div @class([
                            'flex h-full items-center rounded-lg px-3',
                            'bg-brand-600 text-white' => ! $stage->isFinal(),
                            'bg-signal-500 text-ink-900' => $stage->isFinal(),
                        ]) style="width: {{ max(12, (int) round($stageCounts[$stage->value] / $widest * 100)) }}%">
                            <span class="num text-sm font-bold">{{ $stageCounts[$stage->value] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <div class="grid gap-5 lg:grid-cols-[1.4fr_1fr] lg:items-start">
        {{-- Candidates --}}
        <section class="card overflow-hidden">
            <div class="flex items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
                <h2 class="font-semibold text-ink-900">Candidates</h2>
                <a href="{{ route('employer.pipeline') }}" class="link text-sm">Board view</a>
            </div>

            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Candidate</th>
                            <th>Match</th>
                            <th>Verified</th>
                            <th>AI score</th>
                            <th>Stage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stages as $stage)
                            @foreach ($pipeline[$stage->value] ?? [] as $person)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <x-avatar :initials="$person['initials']" tone="paper" size="size-9" />
                                            <div class="min-w-0">
                                                <a href="{{ route('employer.candidates.show') }}" class="font-medium text-ink-900 hover:text-brand-700">{{ $person['name'] }}</a>
                                                <p class="text-xs text-ink-500">{{ $person['location'] }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="num font-semibold">{{ $person['match'] }}</td>
                                    <td>
                                        <x-badge :tone="$person['verified'] === $person['checks'] ? 'pass' : 'warn'">{{ $person['verified'] }}/{{ $person['checks'] }}</x-badge>
                                    </td>
                                    <td class="num">{{ $person['ai_score'] ?? '—' }}</td>
                                    <td><x-status-badge :status="$stage" /></td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Settings summary --}}
        <div class="flex min-w-0 flex-col gap-5">
            <div class="card flex flex-col gap-3 p-5">
                <p class="eyebrow">Published to</p>
                <div class="flex flex-wrap gap-1.5">
                    @foreach ($role['feeds'] as $feed)
                        <x-badge tone="neutral" class="num">{{ $feed }}</x-badge>
                    @endforeach
                </div>
                <p class="num rule pt-3 text-xs text-ink-500">Last synced 4 minutes ago.</p>
            </div>

            <div class="card flex flex-col gap-3 p-5">
                <div class="flex items-center justify-between gap-3">
                    <p class="eyebrow">AI first round</p>
                    <x-status-badge :status="$interview['status']" />
                </div>
                <p class="text-sm text-ink-600">{{ $interview['format'] }} · {{ $interview['duration'] }} · {{ $interview['question_count'] }} questions</p>
                <div class="flex flex-col gap-2.5 pt-1">
                    @foreach ($interview['competencies'] as $competency)
                        <x-meter :value="$competency['weight']" :max="40" :label="$competency['name']" tone="ink" />
                    @endforeach
                </div>
                <a href="{{ route('employer.interviews.show') }}" class="btn btn-secondary btn-sm mt-1">View scorecards</a>
            </div>

            <x-mockup-note>Mockup — one sample pipeline, shown for every role.</x-mockup-note>
        </div>
    </div>
</x-layouts.app>
