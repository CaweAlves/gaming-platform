<?php

namespace App\Enums;

enum FriendshipStatus: string
{
    case Pending  = 'pending';
    case Accepted = 'accepted';

    public function getMessage(): string
    {
        return match ($this) {
            self::Pending  => "Solicitação de amizade pendente.",
            self::Accepted => "Solicitação de amizade aceita."
        };
    }
}
