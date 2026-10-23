<x-layouts.app title="Job feeds" side="admin">
    <x-page-header title="Job feeds" description="Roles are ingested every {{ $syncMinutes }} minutes and de-duplicated by employer and title." eyebrow="Admin console">
        <x-slot:actions>
            <button type="button" class="btn btn-secondary btn-sm">Sync all now</button>
            <button type="button" class="btn btn-ink btn-sm">
                <x-icon name="plus" class="size-4" />
                Connect a source
            </button>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat label="Sources" :value="count($feeds)" hint="{{ collect($feeds)->where('health', 'ok')->count() }} healthy" icon="globe" />
        <x-stat label="Roles live" value="{{ number_format(collect($feeds)->sum('roles')) }}" hint="After de-duplication" icon="briefcase" />
        <x-stat label="Sync interval" value="{{ $syncMinutes }} min" hint="Per source" icon="clock" />
        <x-stat label="Failing" :value="collect($feeds)->where('health', 'error')->count()" hint="LinkedIn auth expired" icon="alert" tone="stop" />
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        @foreach ($feeds as $feed)
            <article class="card flex flex-col gap-4 p-5">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <span @class([
                            'grid size-10 shrink-0 place-items-center rounded-xl',
                            'bg-pass-50 text-pass-700' => $feed['health'] === 'ok',
                            'bg-warn-50 text-warn-700' => $feed['health'] === 'slow',
                            'bg-stop-50 text-stop-700' => $feed['health'] === 'error',
                        ])>
                            <x-icon name="globe" class="size-5" />
                        </span>
                        <div class="min-w-0">
                            <p class="num font-semibold text-ink-900">{{ $feed['provider'] }}</p>
                            <p class="num text-xs text-ink-500">Last synced {{ $feed['synced'] }}</p>
                        </div>
                    </div>
                    <x-badge :tone="match ($feed['health']) { 'ok' => 'pass', 'slow' => 'warn', default => 'stop' }">
                        {{ $feed['health'] === 'ok' ? 'Healthy' : ucfirst($feed['health']) }}
                    </x-badge>
                </div>

                <div class="flex items-baseline justify-between gap-3">
                    <span class="num text-2xl font-bold text-ink-900">{{ number_format($feed['roles']) }}</span>
                    <span class="text-xs text-ink-500">roles ingested</span>
                </div>

                <x-meter
                    :value="$feed['roles']"
                    :max="collect($feeds)->max('roles')"
                    :tone="match ($feed['health']) { 'ok' => 'signal', 'slow' => 'warn', default => 'stop' }"
                />

                @if ($feed['health'] === 'error')
                    <p class="flex items-start gap-2 rounded-lg bg-stop-50 px-3 py-2 text-xs leading-relaxed text-stop-700">
                        <x-icon name="alert" class="mt-px size-3.5 shrink-0" />
                        OAuth token expired 2 hours ago. Roles from this source are stale.
                    </p>
                @endif

                <div class="mt-auto flex gap-2 pt-1">
                    <button type="button" class="btn btn-secondary btn-sm">Sync now</button>
                    <button type="button" class="btn btn-ghost btn-sm">Settings</button>
                </div>
            </article>
        @endforeach
    </div>

    <x-mockup-note>Mockup — sources are sample records and no sync runs.</x-mockup-note>
</x-layouts.app>
