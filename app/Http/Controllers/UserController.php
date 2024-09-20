<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\IUserService;
use Illuminate\Http\{JsonResponse, Request};
use Symfony\Component\HttpFoundation\Response as StatusCode;

class UserController extends Controller
{
    public function __construct(public IUserService $userService)
    {
        $this->userService = $userService;
    }

    public function search(Request $request): JsonResponse
    {
        try {
            $username = $request->input('username');
            $users    = $this->userService->search($username);

            return response()->json(
                ['users' => $users],
                StatusCode::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }
    }
}
