<?php

namespace App\Http\Controllers;

use App\Interfaces\Repositories\IUserRepository;
use Illuminate\Http\{JsonResponse, Request};
use Symfony\Component\HttpFoundation\Response as StatusCode;

class UserController extends Controller
{
    public function __construct(protected IUserRepository $userRepository)
    {
    }

    public function search(Request $request): JsonResponse
    {
        $username = $request->input('username');

        if ($this->userRepository->findByUsername($username)->isEmpty()) {
            return response()->json(['message' => 'nenhum usuario encontrado.'], StatusCode::HTTP_NOT_FOUND);
        }

        return response()->json(
            ['users' => $this->userRepository->findByUsername($username)],
            StatusCode::HTTP_OK
        );
    }
}
