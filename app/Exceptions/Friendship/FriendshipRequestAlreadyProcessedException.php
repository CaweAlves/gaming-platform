<?php

namespace App\Exceptions\Friendship;

use App\Enums\FriendshipStatus;
use Exception;
use Symfony\Component\HttpFoundation\Response as StatusCode;
use Throwable;

class FriendshipRequestAlreadyProcessedException extends Exception
{
    public function __construct(public FriendshipStatus $status, public string $action = 'accepted', $message = "", $code = StatusCode::HTTP_CONFLICT, ?Throwable $previous = null)
    {
        $message = sprintf('The friend request cannot be %s because it has already been %s.', $action, $status->value);
        parent::__construct($message, $code, $previous);
    }
}
