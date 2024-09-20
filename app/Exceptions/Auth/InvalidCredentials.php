<?php

namespace App\Exceptions\Auth;

use Exception;
use Symfony\Component\HttpFoundation\Response as StatusCode;
use Throwable;

class InvalidCredentials extends Exception
{
    public function __construct($message = 'Invalid credentials.', $code = StatusCode::HTTP_UNAUTHORIZED, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
