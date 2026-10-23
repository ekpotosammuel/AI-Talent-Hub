@props(['name', 'class' => 'size-5'])

@php
    $paths = [
        'home' => '<path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/>',
        'sparkles' => '<path d="M12 3v4M12 17v4M3 12h4M17 12h4"/><path d="m6.3 6.3 2.4 2.4M15.3 15.3l2.4 2.4M17.7 6.3l-2.4 2.4M8.7 15.3l-2.4 2.4"/>',
        'document' => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h4"/>',
        'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
        'link' => '<path d="M10 13a5 5 0 0 0 7 0l2-2a5 5 0 0 0-7-7l-1 1"/><path d="M14 11a5 5 0 0 0-7 0l-2 2a5 5 0 0 0 7 7l1-1"/>',
        'mic' => '<rect x="9" y="3" width="6" height="11" rx="3"/><path d="M5 11a7 7 0 0 0 14 0M12 18v3"/>',
        'briefcase' => '<rect x="3" y="7" width="18" height="13" rx="2"/><path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2M3 12h18"/>',
        'users' => '<circle cx="9" cy="8" r="3.2"/><path d="M3 20c0-3.3 2.7-5.5 6-5.5s6 2.2 6 5.5"/><path d="M16 5.5a3 3 0 0 1 0 5.6M18 19.5c0-2.3-.8-3.7-2-4.6"/>',
        'shield' => '<path d="M12 3 5 6v6c0 4.2 2.9 7.8 7 9 4.1-1.2 7-4.8 7-9V6z"/><path d="m9 12 2 2 4-4"/>',
        'id' => '<rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="11" r="2.1"/><path d="M5.8 16.4c.5-1.5 1.8-2.3 3.2-2.3s2.7.8 3.2 2.3M15 10h4M15 13.5h3"/>',
        'globe' => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.5 2.6 2.5 15.4 0 18M12 3c-2.5 2.6-2.5 15.4 0 18"/>',
        'academic' => '<path d="m12 4 9 4.5-9 4.5L3 8.5z"/><path d="M7 10.8V16c0 1.4 2.2 2.5 5 2.5s5-1.1 5-2.5v-5.2M20 9.5V15"/>',
        'badge' => '<circle cx="12" cy="10" r="6"/><path d="m9 15-1.4 6 4.4-2.4L16.4 21 15 15"/><path d="m10 10 1.6 1.6L14.5 8.7"/>',
        'chat' => '<path d="M21 12a8 8 0 0 1-8 8H8l-5 3 1.3-4.4A8 8 0 0 1 13 4a8 8 0 0 1 8 8z"/>',
        'chart' => '<path d="M4 20V4M4 20h16"/><rect x="7.5" y="12" width="3" height="5"/><rect x="12.5" y="8" width="3" height="9"/><rect x="17" y="14" width="3" height="3"/>',
        'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/>',
        'bell' => '<path d="M18 9a6 6 0 1 0-12 0c0 5-2 6-2 6h16s-2-1-2-6"/><path d="M10.3 20a2 2 0 0 0 3.4 0"/>',
        'settings' => '<circle cx="12" cy="12" r="3"/><path d="M12 2.5v3M12 18.5v3M3.6 7.2l2.6 1.5M17.8 15.3l2.6 1.5M3.6 16.8l2.6-1.5M17.8 8.7l2.6-1.5"/>',
        'check' => '<path d="m4.5 12.5 5 5 10-11"/>',
        'x' => '<path d="M6 6l12 12M18 6 6 18"/>',
        'alert' => '<path d="M12 4 2.5 20h19z"/><path d="M12 10v4M12 17h.01"/>',
        'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7.5V12l3 2"/>',
        'arrow-right' => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'arrow-up' => '<path d="M12 19V5M6 11l6-6 6 6"/>',
        'upload' => '<path d="M12 16V4M7 9l5-5 5 5"/><path d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/>',
        'download' => '<path d="M12 4v12M7 11l5 5 5-5"/><path d="M4 18v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-1"/>',
        'filter' => '<path d="M3 5h18l-7 8v6l-4-2v-4z"/>',
        'search' => '<circle cx="11" cy="11" r="6.5"/><path d="m16 16 4.5 4.5"/>',
        'play' => '<path d="M7 4.5v15l12-7.5z"/>',
        'pause' => '<rect x="7" y="5" width="3.5" height="14" rx="1"/><rect x="13.5" y="5" width="3.5" height="14" rx="1"/>',
        'building' => '<rect x="4" y="3" width="11" height="18" rx="1.5"/><path d="M15 9h4.5a.5.5 0 0 1 .5.5V21M7.5 7h4M7.5 11h4M7.5 15h4"/>',
        'card' => '<rect x="2.5" y="5" width="19" height="14" rx="2"/><path d="M2.5 10h19M6 15h4"/>',
        'logout' => '<path d="M15 5H7a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h8"/><path d="m16 12h6M19 9l3 3-3 3"/>',
        'menu' => '<path d="M4 7h16M4 12h16M4 17h16"/>',
        'plus' => '<path d="M12 5v14M5 12h14"/>',
        'phone' => '<rect x="6" y="2.5" width="12" height="19" rx="2.5"/><path d="M10.5 5.5h3"/>',
        'monitor' => '<rect x="2.5" y="4" width="19" height="12.5" rx="2"/><path d="M9 20.5h6M12 16.5v4"/>',
    ];
@endphp

<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" {{ $attributes->class($class) }} aria-hidden="true">
    {!! $paths[$name] ?? $paths['check'] !!}
</svg>
