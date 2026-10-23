<div class="rule-0 flex gap-6 overflow-x-auto border-b border-ink-200 scrollbar-none">
    @foreach ($documents as $item)
        <a href="{{ route($item->routeName()) }}" @class(['tab', 'tab-active' => $item === $document])>
            <x-icon :name="$item->icon()" class="size-4" />
            {{ $item->label() }}
        </a>
    @endforeach
</div>
