<x-layouts.app :title="'Notifications'" :side="$side">
    <x-page-header title="Notifications" description="Matches, verification results, interview invites and stage changes." eyebrow="{{ ucfirst($side) }} account">
        <x-slot:actions>
            <button type="button" class="btn btn-secondary btn-sm">Mark all as read</button>
            <a href="{{ route($side.'.'.($side === 'candidate' ? 'profile' : 'settings')) }}" class="btn btn-ghost btn-sm">
                <x-icon name="settings" class="size-4" />
                Preferences
            </a>
        </x-slot:actions>
    </x-page-header>

    <div class="card divide-y divide-ink-100">
        @foreach ($notifications as $notification)
            <div @class(['flex items-start gap-4 p-5', 'bg-brand-50/40' => $notification['unread']])>
                <span @class([
                    'mt-0.5 grid size-9 shrink-0 place-items-center rounded-lg',
                    'bg-brand-100 text-brand-700' => $notification['tone'] === 'brand',
                    'bg-signal-200 text-signal-700' => $notification['tone'] === 'signal',
                    'bg-warn-50 text-warn-700' => $notification['tone'] === 'warn',
                    'bg-stop-50 text-stop-700' => $notification['tone'] === 'stop',
                ])>
                    <x-icon :name="match ($notification['tone']) { 'signal' => 'sparkles', 'warn' => 'alert', 'stop' => 'chart', default => 'calendar' }" class="size-4" />
                </span>

                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <p class="font-semibold text-ink-900">{{ $notification['title'] }}</p>
                        @if ($notification['unread'])
                            <span class="size-1.5 rounded-full bg-brand-600" aria-label="Unread"></span>
                        @endif
                    </div>
                    <p class="mt-0.5 text-sm leading-relaxed text-ink-600">{{ $notification['body'] }}</p>
                </div>

                <p class="shrink-0 text-xs whitespace-nowrap text-ink-400">{{ $notification['at'] }}</p>
            </div>
        @endforeach
    </div>

    <x-mockup-note>Mockup — notification preferences and read state are not persisted.</x-mockup-note>
</x-layouts.app>
