<x-layouts.app title="Users" side="admin">
    <x-page-header title="Users" description="Candidates, employers and platform operators." eyebrow="Admin console">
        <x-slot:actions>
            <label class="relative">
                <span class="sr-only">Search users</span>
                <x-icon name="search" class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-ink-400" />
                <input type="search" class="input pl-9" placeholder="Search by name or email">
            </label>
        </x-slot:actions>
    </x-page-header>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <x-stat label="Candidates" value="48,219" hint="+1,804 this week" icon="users" />
        <x-stat label="Employers" value="1,276" hint="+38 this week" icon="building" />
        <x-stat label="Operators" value="14" hint="Verification and support" icon="shield" />
        <x-stat label="Deactivated" value="312" hint="Self-serve or by policy" icon="x" tone="warn" />
    </div>

    <section class="card overflow-hidden">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-ink-200 px-5 py-4">
            <h2 class="font-semibold text-ink-900">All users</h2>
            <div class="flex gap-1.5">
                @foreach (['All', 'Candidates', 'Employers', 'Admins'] as $filter)
                    <button type="button" @class(['btn btn-sm', 'btn-ink' => $loop->first, 'btn-secondary' => ! $loop->first])>{{ $filter }}</button>
                @endforeach
            </div>
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
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <x-avatar :initials="\Illuminate\Support\Str::of($user['name'])->explode(' ')->take(2)->map(fn ($part) => \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($part, 0, 1)))->join('')" tone="paper" size="size-9" />
                                    <span class="font-medium text-ink-900">{{ $user['name'] }}</span>
                                </div>
                            </td>
                            <td class="num">{{ $user['email'] }}</td>
                            <td><x-badge :tone="$user['role'] === 'admin' ? 'brand' : 'neutral'">{{ ucfirst($user['role']) }}</x-badge></td>
                            <td class="num whitespace-nowrap">{{ $user['joined'] }}</td>
                            <td><x-status-badge :status="$user['active'] ? 'active' : 'failed'" /></td>
                            <td class="text-right">
                                <button type="button" class="btn btn-ghost btn-sm">{{ $user['active'] ? 'Deactivate' : 'Reactivate' }}</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <x-mockup-note>Mockup — user records are sample data and actions do nothing.</x-mockup-note>
</x-layouts.app>
