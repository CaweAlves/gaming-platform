<?php

namespace App\Interfaces\Services;

use App\Exceptions\Friendship\FriendRequestAlreadyExists;
use App\Models\Friendship;

interface IFriendshipService
{
    public function createRequest(): Friendship|FriendRequestAlreadyExists;
}
