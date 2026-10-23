@props(['title' => null, 'side' => 'candidate'])

@php
    use App\Support\MockData;

    $navigation = [
        'candidate' => [
            'Search & apply' => [
                ['candidate.dashboard', 'Dashboard', 'home'],
                ['candidate.jobs.index', 'Match feed', 'sparkles'],
                ['candidate.applications', 'Applications', 'briefcase'],
            ],
            'Get ready' => [
                ['candidate.review.cv', 'CV review', 'document'],
                ['candidate.review.cover-letter', 'Cover letter', 'mail'],
                ['candidate.review.linkedin', 'LinkedIn review', 'link'],
                ['candidate.interview-prep.index', 'Interview prep', 'mic'],
                ['candidate.feedback', 'Interview feedback', 'chart'],
            ],
            'Account' => [
                ['candidate.verification', 'My verification', 'shield'],
                ['candidate.profile', 'Profile', 'settings'],
                ['candidate.notifications', 'Notifications', 'bell'],
            ],
        ],
        'employer' => [
            'Hiring' => [
                ['employer.dashboard', 'Dashboard', 'home'],
                ['employer.roles.index', 'Roles', 'briefcase'],
                ['employer.pipeline', 'Pipeline', 'users'],
                ['employer.interviews.index', 'AI interviews', 'mic'],
            ],
            'Trust' => [
                ['employer.verification.index', 'Verification', 'shield'],
            ],
            'Employ & manage' => [
                ['employer.eor.index', 'Employer of record', 'globe'],
                ['employer.talent', 'Talent management', 'chart'],
            ],
            'Account' => [
                ['employer.settings', 'Settings & billing', 'settings'],
                ['employer.notifications', 'Notifications', 'bell'],
            ],
        ],
        'admin' => [
            'Console' => [
                ['admin.dashboard', 'Overview', 'home'],
                ['admin.verifications', 'Verification queue', 'shield'],
                ['admin.feeds', 'Job feeds', 'globe'],
                ['admin.users', 'Users', 'users'],
            ],
        ],
    ][$side];

    $identity = match ($side) {
        'candidate' => ['name' => MockData::candidate()['name'], 'initials' => MockData::candidate()['initials'], 'meta' => 'Candidate account', 'tone' => 'brand'],
        'employer' => ['name' => MockData::employer()['company'], 'initials' => MockData::employer()['company_initials'], 'meta' => MockData::employer()['name'].' · '.MockData::employer()['title'], 'tone' => 'ink'],
        'admin' => ['name' => 'Platform admin', 'initials' => 'OP', 'meta' => 'Verification operations', 'tone' => 'paper'],
    };

    $unread = collect(MockData::notifications())->where('unread', true)->count();
    $notificationsRoute = \Illuminate\Support\Facades\Route::has($side.'.notifications') ? $side.'.notifications' : null;
    $switcher = [
        'candidate' => ['employer.dashboard', 'Switch to employer view'],
        'employer' => ['candidate.dashboard', 'Switch to candidate view'],
        'admin' => ['candidate.dashboard', 'Switch to candidate view'],
    ][$side];
@endphp

<x-layouts.base :title="$title" body-class="bg-ink-50">
    <div class="flex min-h-full flex-col lg:flex-row">
        {{-- Sidebar --}}
        <div class="flex items-center justify-between gap-3 border-b border-ink-200 bg-white px-4 py-3 lg:hidden">
            <x-logo />
            <button type="button" class="btn btn-secondary btn-sm" data-nav-toggle="app-sidebar" aria-expanded="false" aria-controls="app-sidebar">
                <x-icon name="menu" class="size-4" />
                Menu
            </button>
        </div>

        <aside id="app-sidebar" class="hidden w-full shrink-0 flex-col gap-6 border-r border-ink-200 bg-white px-4 py-5 lg:sticky lg:top-0 lg:flex lg:h-screen lg:w-64 lg:overflow-y-auto">
            <x-logo class="hidden lg:inline-flex" />

            <div class="flex items-center gap-3 rounded-xl border border-ink-200 bg-ink-50 p-3">
                <x-avatar :initials="$identity['initials']" :tone="$identity['tone']" size="size-9" />
                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-ink-900">{{ $identity['name'] }}</p>
                    <p class="truncate text-xs text-ink-500">{{ $identity['meta'] }}</p>
                </div>
            </div>

            <nav class="flex flex-1 flex-col gap-5" aria-label="{{ ucfirst($side) }} navigation">
                @foreach ($navigation as $group => $links)
                    <div class="flex flex-col gap-1">
                        <p class="eyebrow px-3 pb-1">{{ $group }}</p>
                        @foreach ($links as [$route, $label, $icon])
                            @php($active = request()->routeIs($route) || (str_ends_with($route, '.index') && request()->routeIs(\Illuminate\Support\Str::beforeLast($route, '.').'.*')))
                            <a href="{{ route($route) }}" @class(['sidebar-link', 'sidebar-link-active' => $active])>
                                <x-icon :name="$icon" class="size-4 shrink-0" />
                                <span class="truncate">{{ $label }}</span>
                                @if ($route === $side.'.notifications' && $unread > 0)
                                    <span class="num ml-auto rounded-full bg-brand-600 px-1.5 py-0.5 text-[0.6875rem] font-bold text-white">{{ $unread }}</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                @endforeach
            </nav>

            <div class="flex flex-col gap-2 border-t border-ink-200 pt-4">
                <a href="{{ route($switcher[0]) }}" class="sidebar-link">
                    <x-icon name="users" class="size-4" />
                    {{ $switcher[1] }}
                </a>
                <a href="{{ route('home') }}" class="sidebar-link">
                    <x-icon name="logout" class="size-4" />
                    Log out
                </a>
            </div>
        </aside>

        {{-- Content --}}
        <div class="flex min-w-0 flex-1 flex-col">
            <div class="sticky top-0 z-30 hidden items-center justify-between gap-4 border-b border-ink-200 bg-white/85 px-6 py-3 backdrop-blur-md lg:flex">
                <label class="relative w-full max-w-sm">
                    <span class="sr-only">Search</span>
                    <x-icon name="search" class="pointer-events-none absolute top-1/2 left-3 size-4 -translate-y-1/2 text-ink-400" />
                    <input type="search" class="input pl-9" placeholder="{{ $side === 'employer' ? 'Search candidates, roles, verification references' : 'Search roles, companies, skills' }}">
                </label>

                <div class="flex items-center gap-2">
                    <x-badge tone="neutral" icon="sparkles" class="hidden xl:inline-flex">Mockup build</x-badge>
                    @if ($notificationsRoute)
                        <a href="{{ route($notificationsRoute) }}" class="btn btn-ghost btn-sm relative" aria-label="Notifications">
                            <x-icon name="bell" class="size-4" />
                            @if ($unread > 0)
                                <span class="absolute top-1 right-1 size-2 rounded-full bg-brand-600 ring-2 ring-white"></span>
                            @endif
                        </a>
                    @endif
                    <x-avatar :initials="$identity['initials']" :tone="$identity['tone']" size="size-8" />
                </div>
            </div>

            <main class="flex-1">
                <x-flash />
                <div class="mx-auto flex max-w-7xl flex-col gap-6 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</x-layouts.base>
