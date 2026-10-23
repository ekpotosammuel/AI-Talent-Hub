<?php

namespace App\Enums;

enum AccountType: string
{
    case Candidate = 'candidate';
    case Employer = 'employer';

    public function label(): string
    {
        return match ($this) {
            self::Candidate => 'Candidate',
            self::Employer => 'Employer',
        };
    }

    /**
     * The promise made to this side of the marketplace.
     */
    public function pitch(): string
    {
        return match ($this) {
            self::Candidate => 'Get job-search ready, then matched to roles that actually fit.',
            self::Employer => 'Hire verified talent anywhere, with the compliance handled.',
        };
    }

    public function dashboardRoute(): string
    {
        return match ($this) {
            self::Candidate => 'candidate.dashboard',
            self::Employer => 'employer.dashboard',
        };
    }
}
