<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface IFriendshipRepository
{
    public function pendingRequests(int $user): Collection;
}
