<?php

namespace App\Interfaces\Services;

use App\Exceptions\Auth\InvalidCredentials;

interface IAuthService
{
    public function login(array $credentials): string|InvalidCredentials;
    public function logout(): void;
    public function register(array $data): array;
}
