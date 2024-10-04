<?php

namespace App\Exceptions\Friendship;

use Exception;
use Symfony\Component\HttpFoundation\Response as StatusCode;
use Throwable;

class FriendRequestAlreadyExists extends Exception
{
    public function __construct($message = 'There is already a pending request for this user.', $code = StatusCode::HTTP_CONFLICT, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
