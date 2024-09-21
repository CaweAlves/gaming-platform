<?php

namespace App\Services;

use App\Enums\FriendshipStatus;
use App\Exceptions\Friendship\FriendRequestAlreadyExists;
use App\Interfaces\Repositories\IFriendshipRepository;
use App\Jobs\SendNewFriendRequestMail;
use App\Models\{Friendship, User};

class FriendshipService implements IFriendshipRepository
{
    public function __construct(public IFriendshipRepository $friendshipRepository)
    {
    }

    public function createRequest(int $userId, int $friendId): Friendship|FriendRequestAlreadyExists
    {
        if (
            Friendship::where([
                'requester_id' => $userId,
                'recipient_id' => $friendId,
                'status'       => FriendshipStatus::Pending,
            ])->exists()
        ) {
            throw new FriendRequestAlreadyExists();
        }

        SendNewFriendRequestMail::dispatch(User::find($friendId));

        return $this->friendshipRepository->create(
            [
                'requester_id' => $userId,
                'recipient_id' => $friendId,
                'status'       => FriendshipStatus::Pending,
            ]
        );
    }

    public function accept(int $request): bool
    {
        return $this->friendshipRepository->update($request, ['status' => FriendshipStatus::Accepted]);
    }

    public function reject(int $request): bool
    {
        return $this->friendshipRepository->update($request, ['status' => FriendshipStatus::Rejected]);
    }

}
