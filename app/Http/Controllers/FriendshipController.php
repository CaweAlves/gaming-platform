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

    public function friends(): JsonResponse
    {
        $friends = User::with('friends')
            ->where('id', '=', auth()->user()->getAuthIdentifier())
            ->get()->toArray();

        return response()->json(['friends' => $friends]);
    }

    public function index(): JsonResponse
    {
        $requests = User::with('friendRequests')
            ->where('id', '=', auth()->user()->getAuthIdentifier())
            ->get()->toArray();

        return response()->json(['requests' => $requests]);
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
        try {
            if (!$this->friendshipService->accept($requestFriend)) {
                return response()->json(['message' => 'Erro to accept friend request']);
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
                return response()->json(['message' => 'Erro to reject friend request']);
            }

            return response()->json(['message' => FriendshipStatus::Rejected->getMessage(), 'status' => FriendshipStatus::Rejected]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], $th->getCode());
        }

    }
}
