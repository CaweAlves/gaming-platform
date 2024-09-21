<?php

namespace App\Http\Controllers;

use App\Enums\FriendshipStatus;
use App\Models\User;
use App\Services\FriendshipService;
use Illuminate\Http\{JsonResponse};

class FriendshipController extends Controller
{
    public function __construct(public FriendshipService $friendshipService)
    {
    }

    public function sendRequest(int $friend): JsonResponse
    {
        try {
            $user    = auth()->user()->getAuthIdentifier();
            $request = $this->friendshipService->createRequest($user, $friend);

            return response()->json([
                'request' => $request,
                'friend'  => User::find($friend),
                'message' => FriendshipStatus::Pending->getMessage(),
                'status'  => FriendshipStatus::Pending,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }
    }

    public function acceptRequest(int $requestFriend): JsonResponse
    {
        if (!$this->friendshipService->accept($requestFriend)) {
            return response()->json(['message' => 'Erro to accept friend request']);
        }

        return response()->json(['message' => FriendshipStatus::Accepted->getMessage(), 'status' => FriendshipStatus::Accepted]);
    }

    public function rejectRequest(int $requestFriend): JsonResponse
    {
        if (!$this->friendshipService->reject($requestFriend)) {
            return response()->json(['message' => 'Erro to reject friend request']);
        }

        return response()->json(['message' => FriendshipStatus::Rejected->getMessage(), 'status' => FriendshipStatus::Rejected]);
    }
}
