<x-layouts.app title="Applications" side="candidate">
    <x-page-header
        title="Applications"
        description="Every role you have applied to, and exactly what is holding each one up."
        eyebrow="Tracker"
    >
        <x-slot:actions>
            <a href="{{ route('candidate.jobs.index') }}" class="btn btn-primary btn-sm">
                <x-icon name="plus" class="size-4" />
                Find more roles
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat label="In flight" :value="$active" hint="Not yet closed" icon="briefcase" />
        <x-stat label="Interviewing" value="2" hint="One panel booked this week" icon="mic" tone="pass" />
        <x-stat label="Offers" value="1" hint="Expires Friday" icon="check" tone="pass" />
        <x-stat label="Median match" value="{{ (int) round($applications->avg('match')) }}" hint="Across all applications" icon="sparkles" />
    </div>

    <div class="card overflow-hidden">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
            <h2 class="font-semibold text-ink-900">All applications</h2>
            <div class="flex gap-1.5">
                @foreach (['All', 'Active', 'Closed'] as $filter)
                    <button type="button" @class(['btn btn-sm', 'btn-ink' => $loop->first, 'btn-secondary' => ! $loop->first])>{{ $filter }}</button>
                @endforeach
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Match</th>
                        <th>Stage</th>
                        <th>Next step</th>
                        <th>Applied</th>
                        <th class="text-right">Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <x-avatar :initials="$application['company_initials']" tone="paper" size="size-9" />
                                    <div class="min-w-0">
                                        <p class="font-medium text-ink-900">{{ $application['role'] }}</p>
                                        <p class="text-xs text-ink-500">{{ $application['company'] }} · <span class="num">{{ $application['id'] }}</span></p>
                                    </div>
                                </div>
                            </td>
                            <td class="num font-semibold">{{ $application['match'] }}</td>
                            <td><x-status-badge :status="$application['stage']" /></td>
                            <td class="max-w-xs">{{ $application['next_step'] }}</td>
                            <td class="num whitespace-nowrap text-ink-500">{{ $application['applied'] }}</td>
                            <td class="text-right">
                                @if ($application['has_feedback'])
                                    <a href="{{ route('candidate.feedback') }}" class="btn btn-secondary btn-sm">Read</a>
                                @else
                                    <span class="text-xs text-ink-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Stage legend --}}
    <div class="card flex flex-wrap items-center gap-x-6 gap-y-3 p-5">
        <p class="eyebrow">Stages</p>
        @foreach ($stages as $stage)
            <span class="flex items-center gap-2 text-sm text-ink-600">
                <x-status-badge :status="$stage" />
            </span>
        @endforeach
    </div>

    <x-mockup-note>Mockup — stages come from a fixed sample and do not change.</x-mockup-note>
</x-layouts.app>
