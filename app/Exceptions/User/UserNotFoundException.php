<?php

namespace App\Exceptions\User;

use Exception;
use Symfony\Component\HttpFoundation\Response as StatusCode;
use Throwable;

class UserNotFoundException extends Exception
{
    public function __construct($message = 'No users were found.', $code = StatusCode::HTTP_NOT_FOUND, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
