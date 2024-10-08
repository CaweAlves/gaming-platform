<?php

namespace App\Services;

use App\Enums\FriendshipStatus;
use App\Exceptions\Friendship\{FriendRequestAlreadyExists, FriendshipRequestAlreadyProcessedException};
use App\Interfaces\Repositories\IFriendshipRepository;
use App\Interfaces\Services\IFriendshipService;
use App\Jobs\{SendFriendRequestAcceptedMail, SendFriendRequestRejectedMail, SendNewFriendRequestMail};
use App\Models\{Friendship, User};

class FriendshipService implements IFriendshipService
{
    public function __construct(public IFriendshipRepository $friendshipRepository)
    {
    }

    public function getPendingRequests(int $user): array
    {
        return $this->friendshipRepository->pendingRequests($user)->toArray();
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

        if ($request->status != FriendshipStatus::Pending) {
            throw new FriendshipRequestAlreadyProcessedException(status: $request->status, action: 'accepted');
        }

        SendFriendRequestAcceptedMail::dispatch(User::find($request->requester_id), User::find($request->recipient_id));

        return $this->friendshipRepository->update($request->id, ['status' => FriendshipStatus::Accepted]);
    }

    public function reject(int $request): bool|FriendshipRequestAlreadyProcessedException
    {
        $request = Friendship::find($request);

        if ($request->status != FriendshipStatus::Pending) {
            throw new FriendshipRequestAlreadyProcessedException(status: $request->status, action: 'rejected');
        }

        SendFriendRequestRejectedMail::dispatch(User::find($request->requester_id), User::find($request->recipient_id));

        return $this->friendshipRepository->update($request->id, ['status' => FriendshipStatus::Rejected]);
    }

}
