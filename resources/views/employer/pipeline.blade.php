<x-layouts.app title="Pipeline" side="employer">
    <x-page-header title="Pipeline" description="Drag a candidate between stages. Match score, verification and AI score travel with the card." eyebrow="Hiring">
        <x-slot:actions>
            <label class="flex items-center gap-2 text-sm text-ink-600">
                Role
                <select class="input w-auto py-1.5 text-sm">
                    @foreach ($roles as $option)
                        <option @selected($option['id'] === $role['id'])>{{ $option['title'] }}</option>
                    @endforeach
                </select>
            </label>
            <a href="{{ route('employer.roles.show', ['role' => $role['id']]) }}" class="btn btn-secondary btn-sm">Role detail</a>
        </x-slot:actions>
    </x-page-header>

    <div class="flex flex-wrap items-center gap-3 rounded-xl border border-ink-200 bg-white px-4 py-3">
        <x-badge tone="neutral" class="num">{{ $role['id'] }}</x-badge>
        <p class="text-sm text-ink-600">{{ $role['location'] }} · {{ $role['engagement']->label() }}</p>
        <span class="h-4 w-px bg-ink-200"></span>
        <p class="num text-sm text-ink-600">{{ $role['verified_share'] }}% verified</p>
        <span class="h-4 w-px bg-ink-200"></span>
        <p class="num text-sm text-ink-600">Median {{ $role['days_to_offer'] }} days to offer</p>
    </div>

    <div class="-mx-4 overflow-x-auto px-4 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8" data-board>
        <div class="flex min-w-max gap-4 pb-4">
            @foreach ($stages as $stage)
                @php($people = $pipeline[$stage->value] ?? [])
                <section class="flex w-72 shrink-0 flex-col gap-3" data-stage>
                    <header class="flex items-center justify-between gap-2 rounded-lg bg-white px-3 py-2.5 ring-1 ring-ink-200">
                        <div class="flex items-center gap-2">
                            <span @class([
                                'size-2 rounded-full',
                                'bg-brand-500' => ! $stage->isFinal(),
                                'bg-signal-500' => $stage->isFinal(),
                            ])></span>
                            <h2 class="text-sm font-semibold text-ink-900">{{ $stage->label() }}</h2>
                        </div>
                        <span class="num rounded-md bg-ink-100 px-1.5 py-0.5 text-xs font-bold text-ink-700" data-stage-count>{{ count($people) }}</span>
                    </header>

                    <div class="flex min-h-[8rem] flex-col gap-2.5 rounded-xl bg-ink-100/60 p-2.5 transition" data-stage-drop>
                        @foreach ($people as $person)
                            <x-pipeline-card :person="$person" />
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>
    </div>

    <x-mockup-note>Mockup — cards drag between columns but nothing is saved; reloading resets the board.</x-mockup-note>
</x-layouts.app>
