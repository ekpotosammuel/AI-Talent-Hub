<?php

namespace App\Enums;

enum VerificationCheck: string
{
    case Identity = 'identity';
    case RightToWork = 'right_to_work';
    case Employment = 'employment';
    case Education = 'education';
    case Certification = 'certification';
    case Reference = 'reference';
    case Sanctions = 'sanctions';

    public function label(): string
    {
        return match ($this) {
            self::Identity => 'Government ID',
            self::RightToWork => 'Right to work',
            self::Employment => 'Employment history',
            self::Education => 'Education',
            self::Certification => 'Certifications',
            self::Reference => 'References',
            self::Sanctions => 'Sanctions & adverse media',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Identity => 'Liveness check against a government-issued document.',
            self::RightToWork => 'Work authorisation for the role’s hiring country.',
            self::Employment => 'Titles and dates confirmed with each former employer.',
            self::Education => 'Degrees confirmed with the awarding institution.',
            self::Certification => 'Credential IDs confirmed with the issuing body.',
            self::Reference => 'Structured reference calls with named managers.',
            self::Sanctions => 'Global watchlist, PEP and adverse media screening.',
        };
    }

    /**
     * The upstream data source consulted for this check.
     */
    public function provider(): string
    {
        return config("talent.verification_providers.{$this->value}", 'in-house');
    }

    public function icon(): string
    {
        return match ($this) {
            self::Identity => 'id',
            self::RightToWork => 'globe',
            self::Employment => 'briefcase',
            self::Education => 'academic',
            self::Certification => 'badge',
            self::Reference => 'chat',
            self::Sanctions => 'shield',
        };
    }
}
