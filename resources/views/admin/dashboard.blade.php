<x-layouts.app title="Admin overview" side="admin">
    <x-page-header title="Platform overview" description="Both sides of the marketplace, the verification queue and the feed sync health." eyebrow="Admin console" />

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($overview['stats'] as $stat)
            <x-stat :label="$stat['label']" :value="$stat['value']" :hint="$stat['change']" />
        @endforeach
    </div>

    <div class="grid gap-5 lg:grid-cols-[1.3fr_1fr] lg:items-start">
        <section class="card overflow-hidden">
            <div class="flex items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
                <h2 class="font-semibold text-ink-900">Verification queue</h2>
                <a href="{{ route('admin.verifications') }}" class="link text-sm">Open queue</a>
            </div>
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Candidate</th>
                            <th>Check</th>
                            <th>Waiting</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($overview['queue'] as $item)
                            <tr>
                                <td class="num whitespace-nowrap">{{ $item['reference'] }}</td>
                                <td class="font-medium text-ink-900">{{ $item['candidate'] }}</td>
                                <td class="whitespace-nowrap">{{ $item['check']->label() }}</td>
                                <td class="num whitespace-nowrap">{{ $item['waiting'] }}</td>
                                <td><x-status-badge :status="$item['status']" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="card overflow-hidden">
            <div class="flex items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
                <h2 class="font-semibold text-ink-900">Job feeds</h2>
                <a href="{{ route('admin.feeds') }}" class="link text-sm">Open feeds</a>
            </div>
            <ul class="divide-y divide-ink-100">
                @foreach ($overview['feeds'] as $feed)
                    <li class="flex items-center gap-3.5 px-5 py-3.5">
                        <span @class([
                            'size-2 shrink-0 rounded-full',
                            'bg-pass-500' => $feed['health'] === 'ok',
                            'bg-warn-500' => $feed['health'] === 'slow',
                            'bg-stop-500' => $feed['health'] === 'error',
                        ])></span>
                        <div class="min-w-0 flex-1">
                            <p class="num text-sm font-medium text-ink-900">{{ $feed['provider'] }}</p>
                            <p class="num text-xs text-ink-500">{{ number_format($feed['roles']) }} roles · synced {{ $feed['synced'] }}</p>
                        </div>
                        <x-badge :tone="match ($feed['health']) { 'ok' => 'pass', 'slow' => 'warn', default => 'stop' }" class="shrink-0">
                            {{ $feed['health'] === 'ok' ? 'Healthy' : ucfirst($feed['health']) }}
                        </x-badge>
                    </li>
                @endforeach
            </ul>
        </section>
    </div>

    <section class="card overflow-hidden">
        <div class="flex items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
            <h2 class="font-semibold text-ink-900">Recent users</h2>
            <a href="{{ route('admin.users') }}" class="link text-sm">All users</a>
        </div>
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($overview['users'] as $user)
                        <tr>
                            <td class="font-medium text-ink-900">{{ $user['name'] }}</td>
                            <td class="num">{{ $user['email'] }}</td>
                            <td><x-badge tone="neutral">{{ ucfirst($user['role']) }}</x-badge></td>
                            <td class="num whitespace-nowrap">{{ $user['joined'] }}</td>
                            <td><x-status-badge :status="$user['active'] ? 'active' : 'failed'" /></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <x-mockup-note>Mockup — platform figures are sample values.</x-mockup-note>
</x-layouts.app>
