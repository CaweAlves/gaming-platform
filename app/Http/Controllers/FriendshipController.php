<?php

namespace App\Http\Controllers;

use App\Enums\FriendshipStatus;
use App\Interfaces\Repositories\IFriendshipRepository;
use App\Models\User;
use Illuminate\Http\{JsonResponse, Request};

class FriendshipController extends Controller
{
    public function __construct(public IFriendshipRepository $iFriendshipRepository)
    {
    }

    public function sendRequest(Request $request, int $friend): JsonResponse
    {
        $user    = auth()->user();
        $request = $this->iFriendshipRepository->create(
            [
                'requester_id' => $user->getAuthIdentifier(),
                'recipient_id' => $friend,
                'status'       => FriendshipStatus::Pending,
            ]
        );

        return response()->json([
            'request' => $request,
            'friend'  => User::find($friend),
            'message' => 'Request sending with success.',
            'status'  => FriendshipStatus::Pending,
        ], 201);
    }
}
