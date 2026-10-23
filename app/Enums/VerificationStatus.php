<?php

namespace App\Enums;

enum VerificationStatus: string
{
    case NotStarted = 'not_started';
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Verified = 'verified';
    case Failed = 'failed';
    case Expired = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::NotStarted => 'Not started',
            self::Pending => 'Awaiting candidate',
            self::InProgress => 'Checking',
            self::Verified => 'Verified',
            self::Failed => 'Could not verify',
            self::Expired => 'Expired',
        };
    }

    public function isSettled(): bool
    {
        return in_array($this, [self::Verified, self::Failed, self::Expired], true);
    }
}
