<?php

namespace App\Interfaces\Services;

use App\Exceptions\Friendship\{FriendRequestAlreadyExists, FriendshipRequestAlreadyProcessedException};
use App\Models\Friendship;

interface IFriendshipService
{
    public function getPendingRequests(int $user): array;
    public function createRequest(int $userId, int $friendId): Friendship|FriendRequestAlreadyExists;
    public function accept(int $request): bool;
    public function reject(int $request): bool|FriendshipRequestAlreadyProcessedException;
}
