<?php

namespace App\Enums;

enum ApplicationStage: string
{
    case Matched = 'matched';
    case Applied = 'applied';
    case Screening = 'screening';
    case AiInterview = 'ai_interview';
    case TeamInterview = 'team_interview';
    case Offer = 'offer';
    case Hired = 'hired';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Matched => 'Matched',
            self::Applied => 'Applied',
            self::Screening => 'Screening',
            self::AiInterview => 'AI interview',
            self::TeamInterview => 'Team interview',
            self::Offer => 'Offer',
            self::Hired => 'Hired',
            self::Rejected => 'Not moving forward',
        };
    }

    /**
     * Stages shown as columns on the employer pipeline board.
     *
     * @return list<self>
     */
    public static function pipeline(): array
    {
        return [self::Applied, self::Screening, self::AiInterview, self::TeamInterview, self::Offer, self::Hired];
    }

    public function isFinal(): bool
    {
        return in_array($this, [self::Hired, self::Rejected], true);
    }
}
