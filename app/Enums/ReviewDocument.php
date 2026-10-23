<?php

namespace App\Enums;

enum ReviewDocument: string
{
    case Cv = 'cv';
    case CoverLetter = 'cover_letter';
    case LinkedinProfile = 'linkedin_profile';

    public function label(): string
    {
        return match ($this) {
            self::Cv => 'CV',
            self::CoverLetter => 'Cover letter',
            self::LinkedinProfile => 'LinkedIn profile',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Cv => 'Scored against the role, the ATS parser and a recruiter’s six-second scan.',
            self::CoverLetter => 'Checked for a specific opening, evidence of impact and a clear ask.',
            self::LinkedinProfile => 'Checked for search visibility, headline strength and proof of work.',
        };
    }

    public function routeName(): string
    {
        return match ($this) {
            self::Cv => 'candidate.review.cv',
            self::CoverLetter => 'candidate.review.cover-letter',
            self::LinkedinProfile => 'candidate.review.linkedin',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Cv => 'document',
            self::CoverLetter => 'mail',
            self::LinkedinProfile => 'link',
        };
    }
}
