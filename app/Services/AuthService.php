<?php

namespace App\Services;

use App\Exceptions\AuthException;
use App\Interfaces\Services\IAuthService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService implements IAuthService
{
    public function login(array $credentials): string|AuthException
    {
        if (!Auth::attempt($credentials)) {
            throw AuthException::invalidCredentials();
        }

        $user = Auth::getUser();

        return $user->createToken('auth_token')->accessToken;
    }

    public function logout(): void
    {
        Auth::getUser()->tokens()->delete();

        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
    }

    public function register(array $data): array
    {
        $user = User::create($data);
        auth()->login($user);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'user'  => $user,
        ];
    }
}
