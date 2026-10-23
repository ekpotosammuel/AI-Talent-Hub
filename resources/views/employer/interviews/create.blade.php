<x-layouts.app title="Interview setup" side="employer">
    <x-page-header title="Configure the AI round" description="Set the competencies and their weights. Questions are generated against the role, then you edit them." eyebrow="Trust" />

    <form class="grid gap-5 lg:grid-cols-[1fr_20rem] lg:items-start" onsubmit="event.preventDefault()">
        <div class="flex min-w-0 flex-col gap-5">
            <div class="card flex flex-col gap-5 p-6">
                <h2 class="font-semibold text-ink-900">Scope</h2>
                <div class="grid gap-4 sm:grid-cols-2">
                    <x-field label="Role" name="role">
                        <select id="role" class="input">
                            @foreach ($roles as $role)
                                <option @selected($role['title'] === $interview['role'])>{{ $role['title'] }}</option>
                            @endforeach
                        </select>
                    </x-field>
                    <x-field label="Format" name="format">
                        <select id="format" class="input">
                            <option>Async · voice and screen share</option>
                            <option>Async · voice only</option>
                            <option>Live · scheduled with an interviewer present</option>
                        </select>
                    </x-field>
                    <x-field label="Time limit" name="limit">
                        <select id="limit" class="input">
                            <option>25 min</option>
                            <option>40 min</option>
                            <option>60 min</option>
                        </select>
                    </x-field>
                    <x-field label="Questions" name="questions" hint="Maximum {{ $maxQuestions }} per round.">
                        <input id="questions" type="number" class="input" value="{{ $interview['question_count'] }}" max="{{ $maxQuestions }}">
                    </x-field>
                </div>
            </div>

            <div class="card flex flex-col gap-5 p-6">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h2 class="font-semibold text-ink-900">Competencies and weights</h2>
                    <x-badge tone="neutral" class="num">Total {{ collect($interview['competencies'])->sum('weight') }}%</x-badge>
                </div>

                <div class="flex flex-col gap-5">
                    @foreach ($interview['competencies'] as $competency)
                        <div class="flex flex-wrap items-center gap-4">
                            <label for="weight-{{ $loop->index }}" class="w-44 shrink-0 text-sm font-medium text-ink-800">{{ $competency['name'] }}</label>
                            <input id="weight-{{ $loop->index }}" type="range" min="0" max="50" value="{{ $competency['weight'] }}" class="min-w-[10rem] flex-1 accent-brand-600">
                            <span class="num w-12 shrink-0 text-right text-sm font-bold text-ink-900">{{ $competency['weight'] }}%</span>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="btn btn-secondary btn-sm w-fit">
                    <x-icon name="plus" class="size-3.5" />
                    Add competency
                </button>
            </div>

            <div class="card flex flex-col gap-4 p-6">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h2 class="font-semibold text-ink-900">Questions</h2>
                    <button type="button" class="btn btn-secondary btn-sm">
                        <x-icon name="sparkles" class="size-3.5" />
                        Regenerate from the role
                    </button>
                </div>

                <ol class="flex flex-col gap-3">
                    @foreach ($interview['questions'] as $question)
                        <li class="flex items-start gap-3 rounded-lg border border-ink-200 p-4">
                            <span class="num mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-ink-100 text-xs font-bold text-ink-700">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <p class="min-w-0 flex-1 text-sm leading-relaxed text-ink-800">{{ $question }}</p>
                            <div class="flex shrink-0 gap-1">
                                <button type="button" class="btn btn-ghost btn-sm" aria-label="Edit question">
                                    <x-icon name="document" class="size-3.5" />
                                </button>
                                <button type="button" class="btn btn-ghost btn-sm" aria-label="Remove question">
                                    <x-icon name="x" class="size-3.5" />
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>

        <div class="flex min-w-0 flex-col gap-5">
            <div class="card-ink flex flex-col gap-3 p-5">
                <x-icon name="shield" class="size-5 text-signal-400" />
                <p class="font-semibold text-white">Non-negotiable guardrails</p>
                <ul class="flex flex-col gap-2">
                    @foreach ($interview['guardrails'] as $guardrail)
                        <li class="flex gap-2.5 text-sm leading-relaxed text-ink-300">
                            <x-icon name="check" class="mt-0.5 size-4 shrink-0 text-signal-400" />
                            {{ $guardrail }}
                        </li>
                    @endforeach
                </ul>
                <p class="num mt-1 text-xs text-ink-400">These cannot be switched off.</p>
            </div>

            <div class="card flex flex-col gap-3 p-5">
                <p class="eyebrow">Who reviews</p>
                <x-field label="Named reviewer" name="reviewer">
                    <select id="reviewer" class="input">
                        <option>Priya Raman · Hiring manager</option>
                        <option>Dayo Adeleke · Head of Talent</option>
                        <option>Tom Byrne · Compliance</option>
                    </select>
                </x-field>
                <label class="flex items-start justify-between gap-3 text-sm text-ink-700">
                    <span>Hold all results until reviewed</span>
                    <input type="checkbox" class="checkbox mt-0.5 shrink-0" checked>
                </label>
            </div>

            <div class="card flex flex-col gap-2.5 p-5">
                <button type="submit" class="btn btn-ink w-full">Save and invite</button>
                <button type="button" class="btn btn-secondary w-full">Preview as candidate</button>
            </div>

            <x-mockup-note>Mockup — nothing is saved and no invites are sent.</x-mockup-note>
        </div>
    </form>
</x-layouts.app>
