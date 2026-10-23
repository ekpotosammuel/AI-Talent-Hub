<x-layouts.app title="AI interviews" side="employer">
    <x-page-header title="AI interviews" description="A structured first round, run at any hour. Scores are advisory and every decision has a named reviewer." eyebrow="Trust">
        <x-slot:actions>
            <a href="{{ route('employer.interviews.create') }}" class="btn btn-ink btn-sm">
                <x-icon name="settings" class="size-4" />
                Configure a round
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat label="Invited" :value="$interview['invited']" hint="Across {{ $roles->where('status', 'Live')->count() }} live roles" icon="mail" />
        <x-stat label="Completed" :value="$interview['completed']" hint="{{ (int) round($interview['completed'] / $interview['invited'] * 100) }}% completion" icon="check" tone="pass" />
        <x-stat label="Median score" :value="$interview['median_score']" hint="Out of 100" icon="chart" />
        <x-stat label="Awaiting review" value="4" hint="No decision until a human signs off" icon="users" tone="warn" />
    </div>

    <div class="grid gap-5 lg:grid-cols-[1.3fr_1fr] lg:items-start">
        <section class="card overflow-hidden">
            <div class="flex items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
                <h2 class="font-semibold text-ink-900">Completed interviews</h2>
                <x-badge tone="neutral">{{ $interview['role'] }}</x-badge>
            </div>

            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Candidate</th>
                            <th>Match</th>
                            <th>AI score</th>
                            <th>Review</th>
                            <th class="text-right">Scorecard</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pipeline[\App\Enums\ApplicationStage::AiInterview->value] as $person)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <x-avatar :initials="$person['initials']" tone="paper" size="size-9" />
                                        <div class="min-w-0">
                                            <p class="font-medium text-ink-900">{{ $person['name'] }}</p>
                                            <p class="text-xs text-ink-500">{{ $person['note'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="num font-semibold">{{ $person['match'] }}</td>
                                <td>
                                    @if ($person['ai_score'] !== null)
                                        <span class="num font-semibold">{{ $person['ai_score'] }}</span>
                                    @else
                                        <span class="text-xs text-ink-400">Not started</span>
                                    @endif
                                </td>
                                <td>
                                    <x-status-badge :status="$person['ai_score'] !== null ? 'pending' : 'invited'" />
                                </td>
                                <td class="text-right">
                                    @if ($person['ai_score'] !== null)
                                        <a href="{{ route('employer.interviews.show') }}" class="btn btn-secondary btn-sm">Open</a>
                                    @else
                                        <button type="button" class="btn btn-ghost btn-sm">Remind</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <div class="flex min-w-0 flex-col gap-5">
            <div class="card flex flex-col gap-4 p-5">
                <p class="eyebrow">Round configuration</p>
                <dl class="flex flex-col gap-2.5 text-sm">
                    @foreach ([
                        'Format' => $interview['format'],
                        'Duration' => $interview['duration'],
                        'Questions' => $interview['question_count'],
                        'Model' => config('talent.ai.model'),
                    ] as $label => $value)
                        <div class="flex items-baseline justify-between gap-3">
                            <dt class="text-ink-500">{{ $label }}</dt>
                            <dd class="num font-medium text-ink-900">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>

                <div class="rule flex flex-col gap-2.5 pt-4">
                    @foreach ($interview['competencies'] as $competency)
                        <x-meter :value="$competency['weight']" :max="40" :label="$competency['name']" tone="ink" />
                    @endforeach
                </div>
            </div>

            <div class="card-ink flex flex-col gap-3 p-5">
                <x-icon name="shield" class="size-5 text-signal-400" />
                <p class="font-semibold text-white">Guardrails</p>
                <ul class="flex flex-col gap-2">
                    @foreach ($interview['guardrails'] as $guardrail)
                        <li class="flex gap-2.5 text-sm leading-relaxed text-ink-300">
                            <x-icon name="check" class="mt-0.5 size-4 shrink-0 text-signal-400" />
                            {{ $guardrail }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <x-mockup-note>Mockup — no interviews are actually scheduled or scored.</x-mockup-note>
        </div>
    </div>
</x-layouts.app>
