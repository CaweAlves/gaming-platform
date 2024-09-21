<?php

namespace App\Enums;

enum FriendshipStatus: string
{
    case Pending  = 'pending';
    case Accepted = 'accepted';

    public function getMessage(): string
    {
        return match ($this) {
            self::Pending  => "Request sending with success.",
            self::Accepted => "Friend request accepted successfully.",
        };
    }
}
