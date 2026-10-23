<x-layouts.app title="Roles" side="employer">
    <x-page-header title="Roles" description="Every role you have open, where it is published, and how healthy its pipeline is." eyebrow="Hiring">
        <x-slot:actions>
            <a href="{{ route('employer.roles.create') }}" class="btn btn-ink btn-sm">
                <x-icon name="plus" class="size-4" />
                Post a role
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="flex flex-col gap-4">
        @foreach ($roles as $role)
            <article class="card flex flex-col gap-5 p-5 lg:flex-row lg:items-center">
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('employer.roles.show', ['role' => $role['id']]) }}" class="font-semibold text-ink-900 hover:text-brand-700">{{ $role['title'] }}</a>
                        <x-status-badge :status="strtolower($role['status'])" />
                        <x-badge tone="neutral" class="num">{{ $role['id'] }}</x-badge>
                    </div>
                    <p class="mt-1 text-sm text-ink-500">
                        {{ $role['location'] }} · {{ $role['engagement']->label() }} · <span class="num">{{ $role['salary'] }}</span>
                    </p>
                    <p class="mt-1 text-xs text-ink-500">Opened {{ $role['opened'] }} · hiring manager {{ $role['hiring_manager'] }}</p>
                    <div class="mt-2.5 flex flex-wrap gap-1.5">
                        @foreach ($role['feeds'] as $feed)
                            <x-badge tone="neutral" class="num">{{ $feed }}</x-badge>
                        @endforeach
                    </div>
                </div>

                <div class="grid shrink-0 grid-cols-2 gap-4 sm:grid-cols-4 lg:w-[26rem]">
                    @foreach ([
                        ['Pipeline', $role['pipeline']],
                        ['Matched', $role['matched']],
                        ['Interviewing', $role['in_interview']],
                        ['Offers', $role['offers']],
                    ] as [$label, $value])
                        <div class="rounded-lg bg-ink-50 p-3 text-center">
                            <p class="num text-lg font-bold text-ink-900">{{ $value }}</p>
                            <p class="text-xs text-ink-500">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="flex shrink-0 gap-2">
                    <a href="{{ route('employer.roles.show', ['role' => $role['id']]) }}" class="btn btn-secondary btn-sm">Open</a>
                    <a href="{{ route('employer.pipeline') }}" class="btn btn-ghost btn-sm">Pipeline</a>
                </div>
            </article>
        @endforeach
    </div>

    <x-mockup-note>Mockup — roles are sample records and cannot be edited.</x-mockup-note>
</x-layouts.app>
