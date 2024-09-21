<?php

namespace App\Services;

use App\Enums\FriendshipStatus;
use App\Exceptions\Friendship\FriendRequestAlreadyExists;
use App\Interfaces\Repositories\IFriendshipRepository;
use App\Jobs\{SendFriendRequestAcceptedMail, SendFriendRequestRejectedMail, SendNewFriendRequestMail};
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

        SendNewFriendRequestMail::dispatch(User::find($userId));

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
        $request = Friendship::find($request);
        SendFriendRequestAcceptedMail::dispatch(User::find($request->requester_id), User::find($request->recipient_id));

        return $this->friendshipRepository->update($request->id, ['status' => FriendshipStatus::Accepted]);
    }

    public function reject(int $request): bool
    {
        $request = Friendship::find($request);
        SendFriendRequestRejectedMail::dispatch(User::find($request->requester_id), User::find($request->recipient_id));

        return $this->friendshipRepository->update($request->id, ['status' => FriendshipStatus::Rejected]);
    }

}
