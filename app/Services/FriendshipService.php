<?php

namespace App\Services;

use App\Enums\FriendshipStatus;
use App\Exceptions\Friendship\FriendRequestAlreadyExists;
use App\Interfaces\Repositories\IFriendshipRepository;
use App\Models\Friendship;

class FriendshipService implements IFriendshipRepository
{
    public function __construct(public IFriendshipRepository $iFriendshipRepository)
    {
    }

    public function createRequest(int $userId, int $friendId): Friendship|FriendRequestAlreadyExists
    {
        if (Friendship::where([
            'requester_id' => $userId,
            'recipient_id' => $friendId,
            'status'       => FriendshipStatus::Pending,
        ])->exists()) {
            throw new FriendRequestAlreadyExists();
        }

        return $this->iFriendshipRepository->create(
            [
                'requester_id' => $userId,
                'recipient_id' => $friendId,
                'status'       => FriendshipStatus::Pending,
            ]
        );
    }

}
