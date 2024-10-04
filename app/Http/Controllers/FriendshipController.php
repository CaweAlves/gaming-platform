<?php

namespace App\Http\Controllers;

use App\Enums\FriendshipStatus;
use App\Models\User;
use App\Services\FriendshipService;
use Illuminate\Http\{JsonResponse};
use Symfony\Component\HttpFoundation\Response as StatusCode;

class FriendshipController extends Controller
{
    public function __construct(public FriendshipService $friendshipService)
    {
    }

    public function pendingRequests(): JsonResponse
    {
        $requests = $this->friendshipService->getPendingRequests(auth()->user()->getAuthIdentifier());

        return response()->json(['requests' => $requests], StatusCode::HTTP_OK);
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
            ], StatusCode::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }
    }

    public function acceptRequest(int $requestFriend): JsonResponse
    {
        try {
            if (!$this->friendshipService->accept($requestFriend)) {
                return response()->json(['message' => 'Erro to accept friend request'], StatusCode::HTTP_OK);
            }

            return response()->json(['message' => FriendshipStatus::Accepted->getMessage(), 'status' => FriendshipStatus::Accepted]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }

    }

    public function rejectRequest(int $requestFriend): JsonResponse
    {
        try {
            if (!$this->friendshipService->reject($requestFriend)) {
                return response()->json(['message' => 'Erro to reject friend request'], StatusCode::HTTP_OK);
            }

            return response()->json(['message' => FriendshipStatus::Rejected->getMessage(), 'status' => FriendshipStatus::Rejected]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }

    }
}
