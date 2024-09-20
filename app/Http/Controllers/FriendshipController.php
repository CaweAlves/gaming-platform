<?php

namespace App\Http\Controllers;

use App\Enums\FriendshipStatus;
use App\Models\User;
use App\Services\FriendshipService;
use Illuminate\Http\{JsonResponse, Request};

class FriendshipController extends Controller
{
    public function __construct(public FriendshipService $friendshipService)
    {
    }

    public function sendRequest(Request $request, int $friend): JsonResponse
    {
        $user    = auth()->user()->getAuthIdentifier();
        $request = $this->friendshipService->createRequest($user, $friend);

        return response()->json([
            'request' => $request,
            'friend'  => User::find($friend),
            'message' => 'Request sending with success.',
            'status'  => FriendshipStatus::Pending,
        ], 201);
    }
}
