<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\IAuthService;
use Illuminate\Http\{JsonResponse, Request};
use Symfony\Component\HttpFoundation\Response as StatusCode;

class AuthController extends Controller
{
    protected IAuthService $authService;

    public function __construct(IAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $token       = $this->authService->login($credentials);

        return response()->json(['message' => 'Authorized', 'token' => $token], StatusCode::HTTP_OK);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout();

        return response()->json(status: StatusCode::HTTP_OK);
    }
}
