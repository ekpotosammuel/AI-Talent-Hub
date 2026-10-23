@props(['status'])

@php
    $value = $status instanceof \BackedEnum ? $status->value : (string) $status;
    $label = method_exists($status, 'label') ? $status->label() : ucfirst(str_replace('_', ' ', $value));

    $tone = match ($value) {
        'verified', 'hired', 'completed', 'pass', 'live', 'active' => 'pass',
        'pending', 'in_progress', 'scoring', 'onboarding', 'invited', 'screening', 'warn' => 'warn',
        'failed', 'expired', 'rejected', 'stop' => 'stop',
        'matched', 'applied', 'ai_interview', 'team_interview', 'offer' => 'brand',
        default => 'neutral',
    };
@endphp

<x-badge :tone="$tone" {{ $attributes }}>{{ $label }}</x-badge>
