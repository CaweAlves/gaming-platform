<?php

namespace App\Interfaces\Services;

use App\Exceptions\Friendship\{FriendRequestAlreadyExists, FriendshipRequestAlreadyProcessedException};
use App\Models\Friendship;

interface IFriendshipService
{
    public function createRequest(): Friendship|FriendRequestAlreadyExists;
    public function reject($request): Friendship;
    public function accept($request): Friendship|FriendshipRequestAlreadyProcessedException;
}
