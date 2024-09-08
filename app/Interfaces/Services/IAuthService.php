<?php

namespace App\Interfaces\Services;

use App\Exceptions\AuthException;

interface IAuthService
{
    public function login(array $credentials): string|AuthException;
    public function logout(): void;
}
