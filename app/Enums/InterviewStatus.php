<?php

namespace App\Enums;

enum InterviewStatus: string
{
    case Invited = 'invited';
    case InProgress = 'in_progress';
    case Scoring = 'scoring';
    case Completed = 'completed';
    case Expired = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::Invited => 'Invited',
            self::InProgress => 'In progress',
            self::Scoring => 'Scoring',
            self::Completed => 'Completed',
            self::Expired => 'Expired',
        };
    }
}
