<x-layouts.app title="Dashboard" side="employer">
    <x-page-header
        title="{{ $employer['company'] }}"
        description="{{ $employer['industry'] }} · hiring in {{ count($employer['hiring_countries']) }} countries · {{ $employer['seats_used'] }} of {{ $employer['seats_total'] }} seats used"
        eyebrow="Employer dashboard"
    >
        <x-slot:actions>
            <a href="{{ route('employer.roles.create') }}" class="btn btn-ink btn-sm">
                <x-icon name="plus" class="size-4" />
                Post a role
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat label="In pipeline" :value="$pipelineTotal" hint="Across {{ $roles->where('status', 'Live')->count() }} live roles" icon="users" />
        <x-stat label="Interviewing" :value="$interviewTotal" hint="{{ $interview['completed'] }} AI interviews scored" icon="mic" />
        <x-stat label="Offers out" :value="$offerTotal" hint="One awaiting signature" icon="check" tone="pass" />
        <x-stat label="Employed via EOR" :value="$employees->count()" hint="{{ $employees->where('status', 'Active')->count() }} active, {{ $employees->where('status', '!=', 'Active')->count() }} onboarding" icon="globe" />
    </div>

    {{-- Roles --}}
    <section class="card overflow-hidden">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
            <h2 class="font-semibold text-ink-900">Open roles</h2>
            <a href="{{ route('employer.roles.index') }}" class="link text-sm">Manage roles</a>
        </div>

        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Pipeline</th>
                        <th>Interviewing</th>
                        <th>Verified share</th>
                        <th>Days to offer</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>
                                <a href="{{ route('employer.roles.show', ['role' => $role['id']]) }}" class="font-medium text-ink-900 hover:text-brand-700">{{ $role['title'] }}</a>
                                <p class="text-xs text-ink-500">{{ $role['location'] }} · {{ $role['engagement']->label() }}</p>
                            </td>
                            <td class="num">{{ $role['pipeline'] }} <span class="text-ink-400">({{ $role['matched'] }} matched)</span></td>
                            <td class="num">{{ $role['in_interview'] }}</td>
                            <td class="w-40">
                                <x-meter :value="$role['verified_share']" :tone="$role['verified_share'] >= 80 ? 'signal' : 'warn'" />
                            </td>
                            <td class="num">{{ $role['days_to_offer'] > 0 ? $role['days_to_offer'].' days' : '—' }}</td>
                            <td><x-status-badge :status="strtolower($role['status'])" /></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <div class="grid gap-5 lg:grid-cols-3">
        {{-- Verification --}}
        <section class="card flex flex-col gap-4 p-5">
            <div class="flex items-center justify-between gap-3">
                <h2 class="font-semibold text-ink-900">Verification</h2>
                <a href="{{ route('employer.verification.index') }}" class="link text-sm">All</a>
            </div>

            <div class="flex items-center gap-4">
                <x-score :value="(int) round($verification['cleared'] / $verification['total'] * 100)" :size="76" />
                <div class="min-w-0">
                    <p class="text-sm font-medium text-ink-900">{{ $verification['candidate'] }}</p>
                    <p class="num text-xs text-ink-500">{{ $verification['reference'] }}</p>
                    <p class="mt-1 text-xs text-warn-700">{{ $verification['total'] - $verification['cleared'] }} checks outstanding</p>
                </div>
            </div>

            <div class="rule flex flex-col gap-2 pt-4">
                @foreach (array_slice($verification['checks'], 0, 4) as $check)
                    <div class="flex items-center justify-between gap-2 text-sm">
                        <span class="truncate text-ink-700">{{ $check['check']->label() }}</span>
                        <x-status-badge :status="$check['status']" class="shrink-0" />
                    </div>
                @endforeach
            </div>
        </section>

        {{-- AI interviews --}}
        <section class="card flex flex-col gap-4 p-5">
            <div class="flex items-center justify-between gap-3">
                <h2 class="font-semibold text-ink-900">AI interviews</h2>
                <a href="{{ route('employer.interviews.index') }}" class="link text-sm">Open</a>
            </div>

            <div class="grid grid-cols-3 gap-3 text-center">
                @foreach ([
                    ['Invited', $interview['invited']],
                    ['Completed', $interview['completed']],
                    ['Median', $interview['median_score']],
                ] as [$label, $value])
                    <div class="rounded-lg bg-ink-50 p-3">
                        <p class="num text-xl font-bold text-ink-900">{{ $value }}</p>
                        <p class="text-xs text-ink-500">{{ $label }}</p>
                    </div>
                @endforeach
            </div>

            <div class="rule flex flex-col gap-3 pt-4">
                @foreach ($interview['scorecard']['dimensions'] as $dimension)
                    <x-meter :value="$dimension['score']" :label="$dimension['name']" />
                @endforeach
            </div>
        </section>

        {{-- Talent management --}}
        <section class="card flex flex-col gap-4 p-5">
            <div class="flex items-center justify-between gap-3">
                <h2 class="font-semibold text-ink-900">After the hire</h2>
                <a href="{{ route('employer.talent') }}" class="link text-sm">Roster</a>
            </div>

            @foreach ($roster as $person)
                <div class="flex items-center gap-3">
                    <x-avatar :initials="$person['initials']" tone="paper" size="size-9" />
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-medium text-ink-900">{{ $person['name'] }}</p>
                        <p class="truncate text-xs text-ink-500">{{ $person['flag'] }} {{ $person['role'] }} · {{ $person['tenure'] }}</p>
                    </div>
                    <x-badge :tone="match ($person['risk']) { 'high' => 'stop', 'medium' => 'warn', default => 'pass' }" class="shrink-0">
                        {{ $person['performance'] }}
                    </x-badge>
                </div>
            @endforeach
        </section>
    </div>

    <x-mockup-note>Mockup — all figures come from a fixed sample company.</x-mockup-note>
</x-layouts.app>
