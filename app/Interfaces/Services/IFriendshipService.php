<?php

namespace App\Interfaces\Services;

use App\Models\Friendship;

interface IFriendshipService
{
    public function createRequest(): Friendship;
}
