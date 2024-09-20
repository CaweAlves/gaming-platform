<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response as StatusCode;
use Throwable;

class AuthException extends Exception
{
    public function __construct($message = 'Invalid credentials.', $code = StatusCode::HTTP_UNAUTHORIZED, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
