<?php

namespace App\Enums;

enum EngagementType: string
{
    case DirectHire = 'direct_hire';
    case EmployerOfRecord = 'employer_of_record';
    case Contract = 'contract';

    public function label(): string
    {
        return match ($this) {
            self::DirectHire => 'Direct hire',
            self::EmployerOfRecord => 'Employer of record',
            self::Contract => 'Contract',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::DirectHire => 'You employ them directly. One-off placement fee.',
            self::EmployerOfRecord => 'We are the legal employer in their country. Monthly margin.',
            self::Contract => 'Fixed-term contractor agreement, invoiced monthly.',
        };
    }
}
