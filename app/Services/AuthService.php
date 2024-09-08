<?php

namespace App\Services;

use App\Exceptions\AuthException;
use App\Interfaces\Services\IAuthService;
use Illuminate\Support\Facades\Auth;

class AuthService implements IAuthService
{
    public function login(array $credentials): string|AuthException
    {
        if (!Auth::attempt($credentials)) {
            throw AuthException::invalidCredentials();
        }

        $user = Auth::getUser();

        return $user->createToken('myApp')->accessToken;
    }
}
