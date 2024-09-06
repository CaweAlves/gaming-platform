<?php

namespace App\Http\Controllers;

use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as StatusCode;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Unauthorized'], StatusCode::HTTP_UNAUTHORIZED);
        }

        $token = $request->user()->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'Authorized', 'token' => $token], StatusCode::HTTP_OK);
    }
}
