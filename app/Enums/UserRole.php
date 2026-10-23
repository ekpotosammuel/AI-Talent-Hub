<?php

namespace App\Enums;

enum UserRole: string
{
    case Candidate = 'candidate';
    case Employer = 'employer';
    case Admin = 'admin';

    /**
     * Roles that may be chosen during public self-registration.
     *
     * @return list<string>
     */
    public static function registrable(): array
    {
        return [self::Candidate->value, self::Employer->value];
    }

    public function label(): string
    {
        return ucfirst($this->value);
    }
}
