@if (session('status') || session('error'))
    <div class="mx-auto w-full max-w-7xl px-4 pt-6 sm:px-6 lg:px-8">
        @if (session('status'))
            <div class="flex items-start gap-2.5 rounded-lg border border-brand-200 bg-brand-50 px-4 py-3 text-sm text-brand-900" role="status">
                <x-icon name="check" class="mt-0.5 size-4 shrink-0" />
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-start gap-2.5 rounded-lg border border-stop-500/30 bg-stop-50 px-4 py-3 text-sm text-stop-700" role="alert">
                <x-icon name="alert" class="mt-0.5 size-4 shrink-0" />
                <span>{{ session('error') }}</span>
            </div>
        @endif
    </div>
@endif
