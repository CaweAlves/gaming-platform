<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response as StatusCode;
use Throwable;

class AuthException extends Exception
{
    public function __construct($message = '', $code = StatusCode::HTTP_INTERNAL_SERVER_ERROR, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function invalidCredentials(): self
    {
        return new self(
            'Invalid credentials',
            StatusCode::HTTP_UNAUTHORIZED
        );
    }
}
