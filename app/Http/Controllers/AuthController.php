<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
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
        try {
            $credentials = $request->only('email', 'password');
            $token       = $this->authService->login($credentials);

            return response()->json(['message' => 'Authorized', 'token' => $token], StatusCode::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout();

        return response()->json(status: StatusCode::HTTP_OK);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->all());

        return response()->json($user, StatusCode::HTTP_CREATED);
    }
}
